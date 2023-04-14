<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->load->library('table');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('home');
    }

    public function area()
    {
        $this->load->view('header');
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');

        //table name exact from database
        $crud->set_table('area');

        //give focus on name used for operations e.g. Add Order, Delete Order
        $crud->set_subject('Area');

        //the columns function lists attributes you see on frontend view of the table
        $crud->columns('area_id', 'council_id', 'postcode', 'street_name');

        //the fields function lists attributes to see on add/edit forms.
        //Note no inclusion of invoiceNo as this is auto-incrementing
        $crud->fields('council_id', 'postcode', 'street_name');

        //set the foreign keys to appear as drop-down menus
        // ('this fk column','referencing table', 'column in referencing table')
        $crud->set_relation('council_id', 'local_council', 'council_name');

        //many-to-many relationship with link table see grocery crud website: www.grocerycrud.com/examples/set_a_relation_n_n
        //('give a new name to related column for list in fields here', 'join table', 'other parent table', 'this fk in join table', 'other fk in join table', 'other parent table's viewable column to see in field')
        // $crud->set_relation_n_n('items', 'order_items', 'items', 'invoice_no', 'item_id', 'itemDesc');

        //form validation (could match database columns set to "not null")
        // $crud->required_fields('invoiceNo', 'date', 'custID');

        //change column heading name for readability ('columm name', 'name to display in frontend column header')
        $crud->display_as('council_id', 'Council ');

        $output = $crud->render();
        $this->area_output($output);
    }

    public function area_output($output = null)
    {
        //this function links up to corresponding page in the views folder to display content for this table
        $this->load->view('area_view.php', $output);
    }

    public function resident()
    {
        $this->load->view('header');
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('resident');
        $crud->set_subject('resident');

        $crud->columns('resident_id', 'area_id', 'tittle', 'resident_name', 'phone_no', 'email', 'age', 'resident_status');
        $crud->fields('area_id', 'tittle', 'resident_name', 'phone_no', 'email', 'age');
        $crud->field_type('tittle', 'dropdown', array('1' => 'Mr', '2' => 'Ms', '3' => 'other'));
        $crud->set_relation('area_id', 'area', 'street_name');

        $crud->required_fields('area_id', 'tittle', 'resident_name', 'phone_no', 'email', 'age');
        $crud->set_rules('resident_name', 'Resident Name', 'required|min_length[3]');
        $crud->set_rules('phone_no', 'phone no', 'required|numeric|min_length[11]|max_length[11]');
        $crud->set_rules('email', 'Email', 'required|valid_email');
        $crud->set_rules('age', 'Age', 'required|less_than[110]');

        $crud->display_as('area_id', 'Area');
        $crud->display_as('phone_no', 'Phone No(eg:0XXXXXXXXXX)');

        $output = $crud->render();
        $this->resident_output($output);
    }

    public function resident_output($output = null)
    {
        $this->load->view('resident_view.php', $output);
    }
    public function customers()
    {
        $this->load->view('header');
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('customers');
        $crud->set_subject('customer');
        $crud->fields('custID', 'custName', 'custAddress', 'custTown', 'custPostcode', 'custTel', 'custEmail');
        $crud->required_fields('custID', 'custName', 'custAddress', 'custTown', 'custPostcode', 'custTel', 'custEmail');
        $crud->display_as('custID', 'CustomerID');
        $crud->display_as('custName', 'Name');
        $crud->display_as('custAddress', 'Address');
        $crud->display_as('custTown', 'Town');
        $crud->display_as('custPostcode', 'Postcode');
        $crud->display_as('custTel', 'Phone');
        $crud->display_as('custEmail', 'Email');

        $output = $crud->render();
        $this->cust_output($output);
    }

    public function cust_output($output = null)
    {
        $this->load->view('cust_view.php', $output);
    }

    public function orderline()
    {
        $this->load->view('header');
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('order_items');
        $crud->set_subject('order line');
        $crud->fields('invoice_no', 'item_id', 'itemQty', 'itemPrice');
        $crud->set_relation('invoice_no', 'orders', 'invoiceNo');
        //have multiple columns show in one FK column by concatenation:  www.grocerycrud.com/forums/topic/479-concatenate-two-or-more-fields-into-one-field/
        $crud->set_relation('item_id', 'items', '{itemID} - {itemDesc}');
        $crud->required_fields('invoice_no', 'item_id', 'itemQty', 'itemPrice');
        $crud->display_as('invoice_no', 'InvoiceNo');
        $crud->display_as('item_id', 'ItemID');
        $crud->display_as('itemQty', 'Quantity');
        $crud->display_as('itemPrice', 'Price');

        $output = $crud->render();
        $this->orderline_output($output);
    }

    public function orderline_output($output = null)
    {
        $this->load->view('orderline_view.php', $output);
    }

    public function querynav()
    {
        $this->load->view('header');
        $this->load->view('querynav_view');
    }

    public function query1()
    {
        $this->load->view('header');
        $this->load->view('query1_view');
    }

    public function query2()
    {
        $this->load->view('header');
        $this->load->view('query2_view');
    }

    public function blank()
    {
        $this->load->view('header');
        $this->load->view('blank_view');
    }
}
