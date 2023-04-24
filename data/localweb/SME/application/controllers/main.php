<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// class foo
// {public $name;}
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
        $this->load->view('login');
    }

    public function help()
    {
        $this->load->view('header');
        $this->load->view('help');
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
        $crud->required_fields('council_id', 'postcode', 'street_name');
        //set the foreign keys to appear as drop-down menus
        // ('this fk column','referencing table', 'column in referencing table')
        $crud->set_relation('council_id', 'local_council', 'council_name');
        $crud->set_rules('postcode', 'Postcode', 'required|min_length[5]|max_length[7]|alpha_numeric');
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

    public function action_vote_product($id)
    {
        $product_id = $id;
        // Getting resident ID from cookie
        $email = $_COOKIE['user'];

        $conn = mysqli_connect('localhost', 'root', '', 'cw2');

        // Getting `resident_id` from email in resident table
        $query = "SELECT * FROM resident WHERE email = \"" . $email . "\";";
        $result = mysql_query($query);
        $obj = mysql_fetch_object($result);

        $resident_id = $obj->resident_id;

        if (isset($_POST['YesButton'])) {
            $query = "INSERT INTO vote(product_id, resident_id, has_voted) VALUES ($product_id, $resident_id, \"yes\");";
            echo $query;
            $conn->query($query);

            header("Location: " . site_url("main/product"));
        }

        if (isset($_POST['NoButton'])) {
            $query = "INSERT INTO vote(product_id, resident_id, has_voted) VALUES ($product_id, $resident_id, \"no\");";
            echo $query;
            $conn->query($query);

            header("Location: " . site_url("main/product"));
        }

        echo "<div>
            <h1>Do you Vote for this product?</h1>
                <form id=\"loginForm\" action=\"\" method=\"post\">
                    <input type=\"submit\" name=\"YesButton\" value=\"Yes\" />
                </form>
                <form id=\"loginForm\" action=\"\" method=\"post\">
                    <input type=\"submit\" name=\"NoButton\" value=\"No\" />
                </form>
        </div>";
        echo "<a href='" . site_url('main/product') . "'>Go back to example</a>";
        echo "</div>";
        die();
    }

    public function view_vote()
    {
        echo $this->load->view('header');

        $sql = "SELECT * FROM vote, product, resident WHERE vote.product_id = product.product_id AND vote.resident_id = resident.resident_id;";

        $conn = mysqli_connect('localhost', 'root', '', 'cw2');
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div style="margin: 1rem;padding: 1rem;display: grid;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;border-radius: 1rem;">
                    <span>' . $row['tittle'] . '. ' . $row['resident_name'] . '</span>
                    <span>' . $row['email'] . '</span>
                    <span>' . $row['name'] . ' (£' . $row['price'] . ')</span>
                    <span>' . $row['environment'] . '(L:' . $row['length'] . ' x B:' . $row['breadth'] . ' x H:' . $row['height'] . ')</span>
                    <h3>' . $row['has_voted'] . '</h3>
                </div>';
            }
        }
        echo "<a href='" . site_url('main/area') . "'>Go back to example</a>";
        echo "</div>";
        die();
    }

    public function product()
    {
        $this->load->view('header');
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('product');
        $crud->set_subject('products');

        // $crud->columns('product_id', 'sme_id', 'name', 'description', 'length', 'breadth', 'height','material','environment','price','prod_status');
        // $crud->fields('sme_id', 'name', 'description', 'length', 'breadth', 'height','material','environment','price','prod_status');
        $crud->field_type('prod_status', 'dropdown', array('active' => 'Active', 'inactive' => 'Inactive'));
        $crud->set_relation('sme_id', 'sme', 'company_name');

        $crud->required_fields('sme_id', 'name', 'description', 'length', 'breadth', 'height', 'material', 'environment', 'price', 'prod_status');
        $crud->set_rules('description', 'Product Description', 'required|min_length[5]|max_length[250]');
        $crud->set_rules('length', 'Product Length', 'required|greater_than[0]');
        $crud->set_rules('breadth', 'Product Breadth', 'required|greater_than[0]');
        $crud->set_rules('length', 'Product Height', 'required|greater_than[0]');
        $crud->set_rules('price', 'Product Price', 'required|greater_than[0]');
        
        $maxPrice = $_COOKIE['maxPrice'];
        $crud->where('price <=', $maxPrice);

        // Show vote button only for residents
        $userType = $_COOKIE['userType'];
        if ($userType == 'resident') {
            $crud->add_action('Vote', '', 'main/action_vote_product');

            if (isset($_POST['TogglePrice'])) {
                if ($maxPrice == 10000) {      
                    setcookie('maxPrice', 100, time()+3600, '/');
                    header("Refresh:0");
                } else {
                    setcookie('maxPrice', 10000, time()+3600, '/');
                    header("Refresh:0");
                    }
                }
            
                
          }

          echo "<form method=\"post\">
          <button style=\"position: absolute;top: 145px;left: 150px;z-index:10;\" type=\"submit\" name=\"TogglePrice\">Show/Hide Products Below £100</button>
        </form>";

        

        $crud->display_as('sme_id', 'Company Name');
        $crud->display_as('price', 'Price (£)');
        $crud->display_as('prod_status', 'Product Status');
        // $crud->display_as('custID', 'CustomerID');
        // $crud->display_as('custName', 'Name');
        // $crud->display_as('custAddress', 'Address');
        // $crud->display_as('custTown', 'Town');
        // $crud->display_as('custPostcode', 'Postcode');
        // $crud->display_as('custTel', 'Phone');
        // $crud->display_as('custEmail', 'Email');

        $output = $crud->render();
        $this->product_output($output);
    }

    public function product_output($output = null)
    {
        $this->load->view('product_view.php', $output);
    }
    public function localCouncil()
    {
        $this->load->view('header');
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('local_council');
        $crud->set_subject('local_council');

        $crud->columns('council_id', 'council_name', 'email', 'phone_no');
        $crud->fields('council_name', 'email', 'phone_no');

        $crud->required_fields('council_name', 'email', 'phone_no');
        $crud->set_rules('council_name', 'Council Name', 'required|min_length[3]');
        $crud->set_rules('phone_no', 'phone no', 'required|numeric|min_length[11]|max_length[11]');
        $crud->set_rules('email', 'Email', 'required|valid_email');

        // $crud->display_as('area_id', 'Area');
        $crud->display_as('phone_no', 'Phone No(eg:0XXXXXXXXXX)');

        $output = $crud->render();
        $this->localCouncil_output($output);
    }

    public function localCouncil_output($output = null)
    {
        $this->load->view('localCouncil_view.php', $output);
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