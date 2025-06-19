<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
        $this->load->model('User_model');
        $this->load->model('Product_model');
        $this->load->model('Blog_model');
        $this->load->model('Order_model');
        $this->load->model('Chat_model');
        $this->load->library('form_validation');
        
        // Check if user is admin
        if (!is_admin_logged_in()) {
            redirect_with_message('admin/login', 'Access denied. Admin privileges required.', 'error');
        }
    }
    
    public function dashboard() {
        $data['title'] = 'Admin Dashboard';
        $data['stats'] = $this->Order_model->get_order_statistics();
        $data['stock_stats'] = $this->Order_model->get_stock_statistics();
        $data['recent_orders'] = $this->Order_model->get_all_orders(5);
        $data['top_products'] = $this->Order_model->get_top_selling_products(5);
        $data['monthly_sales'] = $this->Order_model->get_monthly_sales_report();
        $data['total_users'] = count_rows('users', array('role' => 'user'));
        $data['total_products'] = count_rows('products');
        $data['total_blogs'] = count_rows('blogs');
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/templates/footer');
    }
    
    // User Management
    public function users() {
        $data['title'] = 'User Management';
        $data['users'] = $this->User_model->get_all_users();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/users/list', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function block_user($id) {
        if ($this->User_model->block_user($id)) {
            redirect_with_message('admin/users', 'User blocked successfully!');
        } else {
            redirect_with_message('admin/users', 'Failed to block user.', 'error');
        }
    }
    
    public function unblock_user($id) {
        if ($this->User_model->unblock_user($id)) {
            redirect_with_message('admin/users', 'User unblocked successfully!');
        } else {
            redirect_with_message('admin/users', 'Failed to unblock user.', 'error');
        }
    }
    
    public function delete_user($id) {
        if ($this->User_model->delete_user($id)) {
            redirect_with_message('admin/users', 'User deleted successfully!');
        } else {
            redirect_with_message('admin/users', 'Failed to delete user.', 'error');
        }
    }
    
    // Product Management
    public function products() {
        $data['title'] = 'Product Management';
        $data['products'] = $this->Product_model->get_all_products();
        $data['categories'] = get_multiple_rows('categories', array('status' => 'active'));
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/products/list', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function add_product() {
        $this->form_validation->set_rules('name', 'Product Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Add Product';
            $data['categories'] = get_multiple_rows('categories', array('status' => 'active'));
            
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/products/add', $data);
            $this->load->view('admin/templates/footer');
        } else {
            $product_data = array(
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), 'dash', TRUE),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price'),
                'sale_price' => $this->input->post('sale_price') ?: null,
                'category_id' => $this->input->post('category_id'),
                'stock_quantity' => $this->input->post('stock_quantity'),
                'status' => $this->input->post('status') ?: 'active'
            );
            
            // Handle image upload
            if ($_FILES['image']['name']) {
                $upload_path = './uploads/products/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                
                $image_name = upload_file('image', $upload_path);
                if ($image_name) {
                    $product_data['image'] = $image_name;
                }
            }
            
            if ($this->Product_model->add_product($product_data)) {
                redirect_with_message('admin/products', 'Product added successfully!');
            } else {
                redirect_with_message('admin/add_product', 'Failed to add product.', 'error');
            }
        }
    }
    
    public function edit_product($id) {
        $product = $this->Product_model->get_product_by_id($id);
        if (!$product) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Product Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Product';
            $data['product'] = $product;
            $data['categories'] = get_multiple_rows('categories', array('status' => 'active'));
            
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/products/edit', $data);
            $this->load->view('admin/templates/footer');
        } else {
            $product_data = array(
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), 'dash', TRUE),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price'),
                'sale_price' => $this->input->post('sale_price') ?: null,
                'category_id' => $this->input->post('category_id'),
                'stock_quantity' => $this->input->post('stock_quantity'),
                'status' => $this->input->post('status')
            );
            
            // Handle image upload
            if ($_FILES['image']['name']) {
                $upload_path = './uploads/products/';
                $image_name = upload_file('image', $upload_path);
                if ($image_name) {
                    // Delete old image
                    if ($product->image) {
                        delete_file($upload_path . $product->image);
                    }
                    $product_data['image'] = $image_name;
                }
            }
            
            if ($this->Product_model->update_product($id, $product_data)) {
                redirect_with_message('admin/products', 'Product updated successfully!');
            } else {
                redirect_with_message('admin/edit_product/' . $id, 'Failed to update product.', 'error');
            }
        }
    }
    
    public function delete_product($id) {
        if ($this->Product_model->delete_product($id)) {
            redirect_with_message('admin/products', 'Product deleted successfully!');
        } else {
            redirect_with_message('admin/products', 'Failed to delete product.', 'error');
        }
    }
    
    // Blog Management
    public function blogs() {
        $data['title'] = 'Blog Management';
        $data['blogs'] = $this->Blog_model->get_all_blogs();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/blogs/list', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function add_blog() {
        $this->form_validation->set_rules('title', 'Blog Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Add Blog';
            
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/blogs/add', $data);
            $this->load->view('admin/templates/footer');
        } else {
            $blog_data = array(
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', TRUE),
                'content' => $this->input->post('content'),
                'author_id' => $this->session->userdata('user_id'),
                'status' => $this->input->post('status') ?: 'draft'
            );
            
            // Handle image upload
            if ($_FILES['image']['name']) {
                $upload_path = './uploads/blogs/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                
                $image_name = upload_file('image', $upload_path);
                if ($image_name) {
                    $blog_data['image'] = $image_name;
                }
            }
            
            if ($this->Blog_model->add_blog($blog_data)) {
                redirect_with_message('admin/blogs', 'Blog added successfully!');
            } else {
                redirect_with_message('admin/add_blog', 'Failed to add blog.', 'error');
            }
        }
    }
    
    public function edit_blog($id) {
        $blog = $this->Blog_model->get_blog_by_id($id);
        if (!$blog) {
            show_404();
        }
        
        $this->form_validation->set_rules('title', 'Blog Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Blog';
            $data['blog'] = $blog;
            
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/blogs/edit', $data);
            $this->load->view('admin/templates/footer');
        } else {
            $blog_data = array(
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', TRUE),
                'content' => $this->input->post('content'),
                'status' => $this->input->post('status')
            );
            
            // Handle image upload
            if ($_FILES['image']['name']) {
                $upload_path = './uploads/blogs/';
                $image_name = upload_file('image', $upload_path);
                if ($image_name) {
                    // Delete old image
                    if ($blog->image) {
                        delete_file($upload_path . $blog->image);
                    }
                    $blog_data['image'] = $image_name;
                }
            }
            
            if ($this->Blog_model->update_blog($id, $blog_data)) {
                redirect_with_message('admin/blogs', 'Blog updated successfully!');
            } else {
                redirect_with_message('admin/edit_blog/' . $id, 'Failed to update blog.', 'error');
            }
        }
    }
    
    public function delete_blog($id) {
        if ($this->Blog_model->delete_blog($id)) {
            redirect_with_message('admin/blogs', 'Blog deleted successfully!');
        } else {
            redirect_with_message('admin/blogs', 'Failed to delete blog.', 'error');
        }
    }
    
    // Order Management
    public function orders() {
        $data['title'] = 'Order Management';
        $data['orders'] = $this->Order_model->get_all_orders();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/orders/list', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function view_order($id) {
        $data['title'] = 'Order Details';
        $data['order'] = $this->Order_model->get_order_by_id($id);
        $data['order_items'] = $this->Order_model->get_order_items($id);
        
        if (!$data['order']) {
            show_404();
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/orders/view', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function update_order_status($id) {
        $status = $this->input->post('status');
        
        if ($this->Order_model->update_order_status($id, $status)) {
            redirect_with_message('admin/orders', 'Order status updated successfully!');
        } else {
            redirect_with_message('admin/orders', 'Failed to update order status.', 'error');
        }
    }
    
    // Reports
    public function reports() {
        $data['title'] = 'Sales Reports';
        
        // Get date range from request
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        $year = $this->input->get('year') ?: date('Y');
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['year'] = $year;
        
        // Get various reports
        $data['sales_report'] = $this->Order_model->get_sales_report($start_date, $end_date);
        $data['daily_sales'] = $this->Order_model->get_daily_sales_report($start_date, $end_date);
        $data['monthly_sales'] = $this->Order_model->get_monthly_sales_report($year);
        $data['top_products'] = $this->Order_model->get_top_selling_products(10);
        $data['order_stats'] = $this->Order_model->get_order_statistics();
        $data['stock_stats'] = $this->Order_model->get_stock_statistics();
        
        // Get low stock products
        $data['low_stock_products'] = get_multiple_rows('products', array('stock_quantity <' => 10, 'status' => 'active'), '*', 'stock_quantity ASC');
        
        // Get out of stock products
        $data['out_of_stock_products'] = get_multiple_rows('products', array('stock_quantity' => 0, 'status' => 'active'));
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/reports/index', $data);
        $this->load->view('admin/templates/footer');
    }
    
    // Export Orders to PDF
    public function export_orders_pdf() {
        $orders = $this->Order_model->get_all_orders();
        
        // Load TCPDF library
        $this->load->library('pdf');
        
        $html = '
        <style>
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; font-weight: bold; }
            .header { text-align: center; margin-bottom: 30px; }
            .total { font-weight: bold; }
        </style>
        
        <div class="header">
            <h1>Orders Report</h1>
            <p>Generated on: ' . date('F d, Y H:i:s') . '</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>';
        
        $total_revenue = 0;
        foreach ($orders as $order) {
            $html .= '
                <tr>
                    <td>' . $order->order_number . '</td>
                    <td>' . ($order->customer_name ?? 'Guest') . '</td>
                    <td>' . ($order->customer_email ?? 'N/A') . '</td>
                    <td>$' . number_format($order->total_amount, 2) . '</td>
                    <td>' . ucfirst($order->status) . '</td>
                    <td>' . date('M d, Y', strtotime($order->created_at)) . '</td>
                </tr>';
            $total_revenue += $order->total_amount;
        }
        
        $html .= '
            </tbody>
        </table>
        
        <div class="total">
            <p>Total Orders: ' . count($orders) . '</p>
            <p>Total Revenue: $' . number_format($total_revenue, 2) . '</p>
        </div>';
        
        $this->pdf->createPDF($html, 'orders_report_' . date('Y-m-d'), true);
    }
    
    // Export Orders to Excel
    public function export_orders_excel() {
        $orders = $this->Order_model->get_all_orders();
        
        // Load Excel library
        $this->load->library('excel');
        
        // Prepare data for Excel
        $excel_data = array();
        
        // Add headers
        $excel_data[] = array('Order #', 'Customer', 'Email', 'Total', 'Status', 'Date');
        
        // Add data rows
        foreach ($orders as $order) {
            $excel_data[] = array(
                $order->order_number,
                $order->customer_name ?? 'Guest',
                $order->customer_email ?? 'N/A',
                '$' . number_format($order->total_amount, 2),
                ucfirst($order->status),
                date('M d, Y', strtotime($order->created_at))
            );
        }
        
        $this->excel->createExcel($excel_data, 'orders_report_' . date('Y-m-d'), true);
    }
    
    // Export Single Order to PDF
    public function export_order_pdf($order_id) {
        $order = $this->Order_model->get_order_by_id($order_id);
        $order_items = $this->Order_model->get_order_items($order_id);
        
        if (!$order) {
            show_404();
        }
        
        // Load TCPDF library
        $this->load->library('pdf');
        
        $html = '
        <style>
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; font-weight: bold; }
            .header { text-align: center; margin-bottom: 30px; }
            .order-info { margin-bottom: 20px; }
            .total { font-weight: bold; }
        </style>
        
        <div class="header">
            <h1>Order Invoice</h1>
            <p>Order #: ' . $order->order_number . '</p>
            <p>Date: ' . date('F d, Y', strtotime($order->created_at)) . '</p>
        </div>
        
        <div class="order-info">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> ' . ($order->customer_name ?? 'Guest') . '</p>
            <p><strong>Email:</strong> ' . ($order->customer_email ?? 'N/A') . '</p>
            <p><strong>Address:</strong> ' . $order->shipping_address . '</p>
            <p><strong>Payment Method:</strong> ' . $order->payment_method . '</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($order_items as $item) {
            $html .= '
                <tr>
                    <td>' . $item->product_name . '</td>
                    <td>' . $item->quantity . '</td>
                    <td>$' . number_format($item->price, 2) . '</td>
                    <td>$' . number_format($item->price * $item->quantity, 2) . '</td>
                </tr>';
        }
        
        $html .= '
            </tbody>
        </table>
        
        <div class="total">
            <h3>Total Amount: $' . number_format($order->total_amount, 2) . '</h3>
            <p>Status: ' . ucfirst($order->status) . '</p>
        </div>';
        
        $this->pdf->createPDF($html, 'order_' . $order->order_number, true);
    }
    
    // Export Reports to PDF
    public function export_reports_pdf() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        $year = $this->input->get('year') ?: date('Y');
        
        $order_stats = $this->Order_model->get_order_statistics();
        $stock_stats = $this->Order_model->get_stock_statistics();
        $top_products = $this->Order_model->get_top_selling_products(10);
        $monthly_sales = $this->Order_model->get_monthly_sales_report($year);
        
        // Load TCPDF library
        $this->load->library('pdf');
        
        $html = '
        <style>
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; font-weight: bold; }
            .header { text-align: center; margin-bottom: 30px; }
            .section { margin-bottom: 30px; }
            .stats { margin-bottom: 20px; }
        </style>
        
        <div class="header">
            <h1>Sales Report</h1>
            <p>Period: ' . date('M d, Y', strtotime($start_date)) . ' to ' . date('M d, Y', strtotime($end_date)) . '</p>
            <p>Generated on: ' . date('F d, Y H:i:s') . '</p>
        </div>
        
        <div class="section">
            <h2>Summary Statistics</h2>
            <div class="stats">
                <p><strong>Total Revenue:</strong> $' . number_format($order_stats['total_revenue'], 2) . '</p>
                <p><strong>Total Orders:</strong> ' . $order_stats['total_orders'] . '</p>
                <p><strong>Pending Orders:</strong> ' . $order_stats['pending_orders'] . '</p>
                <p><strong>Completed Orders:</strong> ' . $order_stats['completed_orders'] . '</p>
                <p><strong>Monthly Revenue:</strong> $' . number_format($order_stats['monthly_revenue'], 2) . '</p>
            </div>
        </div>
        
        <div class="section">
            <h2>Stock Information</h2>
            <div class="stats">
                <p><strong>Total Stock:</strong> ' . $stock_stats['total_stock'] . '</p>
                <p><strong>Low Stock Products:</strong> ' . $stock_stats['low_stock_products'] . '</p>
                <p><strong>Out of Stock Products:</strong> ' . $stock_stats['out_of_stock_products'] . '</p>
                <p><strong>In Stock Products:</strong> ' . $stock_stats['in_stock_products'] . '</p>
            </div>
        </div>
        
        <div class="section">
            <h2>Top Selling Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Sold</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($top_products as $product) {
            $html .= '
                <tr>
                    <td>' . $product->name . '</td>
                    <td>' . $product->total_sold . '</td>
                    <td>$' . number_format($product->total_revenue, 2) . '</td>
                </tr>';
        }
        
        $html .= '
                </tbody>
            </table>
        </div>
        
        <div class="section">
            <h2>Monthly Sales (' . $year . ')</h2>
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Orders</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>';
        
        $months = array(
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        );
        
        foreach ($monthly_sales as $sale) {
            $html .= '
                <tr>
                    <td>' . $months[$sale->month] . '</td>
                    <td>' . $sale->total_orders . '</td>
                    <td>$' . number_format($sale->total_revenue, 2) . '</td>
                </tr>';
        }
        
        $html .= '
                </tbody>
            </table>
        </div>';
        
        $this->pdf->createPDF($html, 'sales_report_' . date('Y-m-d'), true);
    }
    
    // Export Reports to Excel
    public function export_reports_excel() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        $year = $this->input->get('year') ?: date('Y');
        
        $order_stats = $this->Order_model->get_order_statistics();
        $stock_stats = $this->Order_model->get_stock_statistics();
        $top_products = $this->Order_model->get_top_selling_products(10);
        $monthly_sales = $this->Order_model->get_monthly_sales_report($year);
        
        // Load Excel library
        $this->load->library('excel');
        
        // Prepare data for Excel
        $excel_data = array();
        
        // Add report header
        $excel_data[] = array('Sales Report');
        $excel_data[] = array('Period: ' . date('M d, Y', strtotime($start_date)) . ' to ' . date('M d, Y', strtotime($end_date)));
        $excel_data[] = array('Generated on: ' . date('F d, Y H:i:s'));
        $excel_data[] = array(''); // Empty row
        
        // Add summary statistics
        $excel_data[] = array('Summary Statistics');
        $excel_data[] = array('Metric', 'Value');
        $excel_data[] = array('Total Revenue', '$' . number_format($order_stats['total_revenue'], 2));
        $excel_data[] = array('Total Orders', $order_stats['total_orders']);
        $excel_data[] = array('Pending Orders', $order_stats['pending_orders']);
        $excel_data[] = array('Completed Orders', $order_stats['completed_orders']);
        $excel_data[] = array('Monthly Revenue', '$' . number_format($order_stats['monthly_revenue'], 2));
        $excel_data[] = array(''); // Empty row
        
        // Add stock information
        $excel_data[] = array('Stock Information');
        $excel_data[] = array('Metric', 'Value');
        $excel_data[] = array('Total Stock', $stock_stats['total_stock']);
        $excel_data[] = array('Low Stock Products', $stock_stats['low_stock_products']);
        $excel_data[] = array('Out of Stock Products', $stock_stats['out_of_stock_products']);
        $excel_data[] = array('In Stock Products', $stock_stats['in_stock_products']);
        $excel_data[] = array(''); // Empty row
        
        // Add top selling products
        $excel_data[] = array('Top Selling Products');
        $excel_data[] = array('Product', 'Quantity Sold', 'Total Revenue');
        foreach ($top_products as $product) {
            $excel_data[] = array(
                $product->name,
                $product->total_sold,
                '$' . number_format($product->total_revenue, 2)
            );
        }
        $excel_data[] = array(''); // Empty row
        
        // Add monthly sales
        $excel_data[] = array('Monthly Sales (' . $year . ')');
        $excel_data[] = array('Month', 'Orders', 'Revenue');
        
        $months = array(
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        );
        
        foreach ($monthly_sales as $sale) {
            $excel_data[] = array(
                $months[$sale->month],
                $sale->total_orders,
                '$' . number_format($sale->total_revenue, 2)
            );
        }
        
        $this->excel->createExcel($excel_data, 'sales_report_' . date('Y-m-d'), true);
    }
    
    // Export Products to PDF
    public function export_products_pdf() {
        $products = $this->Product_model->get_all_products();
        
        // Load PDF library
        $this->load->library('pdf');
        
        $html = '
        <style>
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; font-weight: bold; }
            .header { text-align: center; margin-bottom: 30px; }
            .total { font-weight: bold; }
        </style>
        
        <div class="header">
            <h1>Products Report</h1>
            <p>Generated on: ' . date('F d, Y H:i:s') . '</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
        
        $total_stock = 0;
        $active_products = 0;
        foreach ($products as $product) {
            $html .= '
                <tr>
                    <td>' . $product->id . '</td>
                    <td>' . $product->name . '</td>
                    <td>' . $product->category_name . '</td>
                    <td>$' . number_format($product->price, 2) . '</td>
                    <td>' . $product->stock_quantity . '</td>
                    <td>' . ucfirst($product->status) . '</td>
                </tr>';
            $total_stock += $product->stock_quantity;
            if ($product->status == 'active') {
                $active_products++;
            }
        }
        
        $html .= '
            </tbody>
        </table>
        
        <div class="total">
            <p>Total Products: ' . count($products) . '</p>
            <p>Active Products: ' . $active_products . '</p>
            <p>Total Stock: ' . $total_stock . '</p>
        </div>';
        
        $this->pdf->createPDF($html, 'products_report_' . date('Y-m-d'), true);
    }
    
    // Export Products to Excel
    public function export_products_excel() {
        $products = $this->Product_model->get_all_products();
        
        // Load Excel library
        $this->load->library('excel');
        
        // Prepare data for Excel
        $excel_data = array();
        
        // Add headers
        $excel_data[] = array('ID', 'Name', 'Category', 'Price', 'Stock', 'Status');
        
        // Add data rows
        $total_stock = 0;
        $active_products = 0;
        foreach ($products as $product) {
            $excel_data[] = array(
                $product->id,
                $product->name,
                $product->category_name,
                '$' . number_format($product->price, 2),
                $product->stock_quantity,
                ucfirst($product->status)
            );
            $total_stock += $product->stock_quantity;
            if ($product->status == 'active') {
                $active_products++;
            }
        }
        
        // Add summary
        $excel_data[] = array(''); // Empty row
        $excel_data[] = array('Summary');
        $excel_data[] = array('Metric', 'Value');
        $excel_data[] = array('Total Products', count($products));
        $excel_data[] = array('Active Products', $active_products);
        $excel_data[] = array('Total Stock', $total_stock);
        
        $this->excel->createExcel($excel_data, 'products_report_' . date('Y-m-d'), true);
    }
    
    // Chat Management
    public function chat() {
        $data['title'] = 'Chat Management';
        $data['chat_rooms'] = $this->Chat_model->get_admin_rooms();
        $data['unread_count'] = $this->Chat_model->get_admin_unread_count();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/chat/index', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function chat_room($room_id) {
        $room = $this->db->where('id', $room_id)->get('chat_rooms')->row();
        if (!$room) {
            show_404();
        }
        
        $user = $this->db->where('id', $room->user_id)->get('users')->row();
        $messages = $this->Chat_model->get_room_messages($room_id);
        
        // Mark user messages as read
        $this->Chat_model->mark_as_read($room_id, 'user');
        
        $data['title'] = 'Chat with ' . ($user ? $user->name : 'User');
        $data['room'] = $room;
        $data['user'] = $user;
        $data['messages'] = $messages;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/chat/room', $data);
        $this->load->view('admin/templates/footer');
    }
    
    // AJAX method to send admin message
    public function send_admin_message() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $room_id = $this->input->post('room_id');
        $message = trim($this->input->post('message'));
        
        if (empty($message)) {
            echo json_encode(array('success' => false, 'message' => 'Message cannot be empty'));
            return;
        }
        
        // Send message
        $message_id = $this->Chat_model->send_message($room_id, 1, 'admin', $message);
        
        if ($message_id) {
            echo json_encode(array(
                'success' => true, 
                'message_id' => $message_id,
                'timestamp' => date('H:i')
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to send message'));
        }
    }
    
    // AJAX method to get room messages
    public function get_room_messages($room_id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $messages = $this->Chat_model->get_room_messages($room_id);
        
        // Mark user messages as read
        $this->Chat_model->mark_as_read($room_id, 'user');
        
        $formatted_messages = array();
        foreach ($messages as $msg) {
            $formatted_messages[] = array(
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_type' => $msg->sender_type,
                'timestamp' => date('H:i', strtotime($msg->created_at)),
                'is_read' => $msg->is_read
            );
        }
        
        echo json_encode(array(
            'success' => true,
            'messages' => $formatted_messages
        ));
    }
    
    // AJAX method to check for new messages in admin room
    public function check_admin_new_messages($room_id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $last_message_id = $this->input->post('last_message_id');
        
        // Get new messages
        $new_messages = $this->db->where('room_id', $room_id)
                                 ->where('id >', $last_message_id)
                                 ->where('sender_type', 'user')
                                 ->order_by('created_at', 'ASC')
                                 ->get('chat_messages')
                                 ->result();
        
        // Mark as read
        if (!empty($new_messages)) {
            $this->Chat_model->mark_as_read($room_id, 'user');
        }
        
        $formatted_messages = array();
        foreach ($new_messages as $msg) {
            $formatted_messages[] = array(
                'id' => $msg->id,
                'message' => $msg->message,
                'timestamp' => date('H:i', strtotime($msg->created_at))
            );
        }
        
        echo json_encode(array(
            'success' => true,
            'new_messages' => $formatted_messages
        ));
    }
    
    // Delete chat room
    public function delete_chat_room($room_id) {
        if ($this->Chat_model->delete_room($room_id)) {
            redirect_with_message('admin/chat', 'Chat room deleted successfully!');
        } else {
            redirect_with_message('admin/chat', 'Failed to delete chat room.', 'error');
        }
    }
} 