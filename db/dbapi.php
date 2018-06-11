<?php
@session_start();
$db = new PDO('mysql:host=localhost;dbname=webpos;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

/* user and company management */


function login($username,$password){
    global $db;
    try{
    $sql = "SELECT * FROM stock_user WHERE username=? and password=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($username,$password));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if($count>0){
        $result["status"]="ok";
        $_SESSION["id"]=$rslt[0]["id"];
        $_SESSION["username"]=$rslt[0]["username"];
        $_SESSION["usertype"] = $rslt[0]["user_type"];
    }else{
        $result["status"]="fail";
    }
    } catch (Exception $ex) {
        $result["status"]=$ex->getMessage();
    }
    return $result;
}

function isLogggedIn() {
    if (isset($_SESSION['id'])) {
        return true;
    }
}

function logout($sessionVar) {
    session_destroy();
    unset($sessionVar);
    return true;
}

function create_user($username,$password,$user_type,$answer)
        {
     global $db;
  try{
      $stmt = $db->prepare("insert into stock_user (username,password,user_type,answer,CreatedBy) values(?,?,?,?,?)");
      $stmt->execute(array($username,$password,$user_type,$answer,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}

function get_all_users()
{
     global $db;
  
    try {
        $stm = $db->prepare('SELECT * FROM stock_user');
        $stm->execute();
        $rslt = $stm->fetchAll(PDO::FETCH_ASSOC);  
    } 
    catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}

function get_user_det($id){
     global $db;
  
    try {
        $stm = $db->prepare('SELECT * FROM stock_user where id=?');
        $stm->execute(array($id));
        $rslt = $stm->fetchAll(PDO::FETCH_ASSOC);  
    } 
    catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}


function create_store($name,$address,$city,$phone,$email,$tax_condition,$vat,$bpn){
  global $db;
  try{
      $stmt = $db->prepare("insert into store_details (name,address,city,phone ,email,tax_condition, vat,bpn) values(?,?,?,?,?,?,?,?)");
      $stmt->execute(array($name,$address,$city,$phone,$email,$tax_condition,$vat,$bpn));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}


function get_co_details(){
      global $db;
  
    try {
        $stm = $db->prepare('SELECT * FROM store_details');
        $stm->execute();
        $rslt = $stm->fetchAll(PDO::FETCH_ASSOC);
        $count = $stm->rowCount();
        if($count>0)
            {
        $_SESSION['logo']=$rslt[0]["log"];
        }
      
    } catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}


/* user and co mgt ends here */

//customerfunctions
function new_customer($cust_name,$cust_address,$cust_contact){
  global $db;
  try{
      $stmt = $db->prepare("insert into customer_details(customer_name,customer_address,customer_contact1,Created_BY) values(?,?,?,?)");
      $stmt->execute(array($cust_name,$cust_address,$cust_contact,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;   
}

function edit_customer($customer_name,$customer_address,$customer_contact,$id)
{
    global $db;
  try{
      $stmt = $db->prepare("update customer_details set customer_name=?,customer_address=?,customer_contact1=? where id=?");
      $stmt->execute(array($customer_name,$customer_address,$customer_contact,$id));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result; 
}

function get_customers_except_($id)
{
      global $db;
  
    try {
        $stm = $db->prepare('SELECT * FROM customer_details where id!=? and status="active"');
        $stm->execute(array($id));
        $rslt = $stm->fetchAll(PDO::FETCH_ASSOC);
      
    } catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}

function get_customer_details($cid){
      global $db;
  
    try {
        $stm = $db->prepare('SELECT * FROM customer_details where customer_name=? and status="active"');
        $stm->execute(array($cid));
        $rslt = $stm->fetchAll(PDO::FETCH_ASSOC);
      
    } catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}

function get_all_customers(){
      global $db;
  
    try {
        $stm = $db->prepare('SELECT * FROM customer_details where status="active"');
        $stm->execute();
        $rslt = $stm->fetchAll(PDO::FETCH_ASSOC);
      
    } catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}




/* products fuctions */
function create_stock($code,$name,$start_qty,$tax_code,$cost_price,$selling_price,$category,$expire_date,$uom){
  global $db;
  try{
      $stmt = $db->prepare("insert into stock_details(stock_id,stock_name,stock_quatity,Tax_Code,company_price,selling_price,category,CreatedBy,expire_date,uom) values(?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute(array($code,$name,$start_qty,$tax_code,$cost_price,$selling_price,$category,$_SESSION["id"],$expire_date,$uom));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}



function edit_stock($code,$name,$tax_code,$cost_price,$selling_price,$category,$expire_date,$uom,$id){
  global $db;
  try{
      $stmt = $db->prepare("update stock_details set stock_id=?,stock_name=?,Tax_Code=?,company_price=?,selling_price=?,category=?,expire_date=?,uom=? where id=?");
      $stmt->execute(array($code,$name,$tax_code,$cost_price,$selling_price,$category,$expire_date,$uom,$id));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}

function get_prod_details($sid){
    global $db;
    try{
    $sql = "SELECT * FROM stock_details where status ='active' and (id=? or stock_id=?)";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($sid,$sid));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

function update_prod_qty($qty,$id){
    global $db;
  try{
      $stmt = $db->prepare("update stock_details set stock_quatity=? where id=?");
      $stmt->execute(array($qty,$id));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}

function get_all_prods(){
    global $db;
    try{
    $sql = "SELECT * FROM stock_details where status ='active' order by category asc";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

function get_all_prods_excl_this($id){
    global $db;
    try{
    $sql = "SELECT * FROM stock_details where status ='active' and id!=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}



/* product function ends here */

/* category function starts here */
/* category function starts here */
function get_cat(){
    global $db;
    try{
    $sql = "SELECT * FROM category_details";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

/* category function starts here */
function get_category($sid){
    global $db;
    try{
    $sql = "SELECT * FROM category_details where id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($sid));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}
//print_r (get_category(21));

function edit_category($category_name,$category_description,$id){
  global $db;
  try{
      $stmt = $db->prepare("update category_details set category_name=?,category_description=? where id=?");
      $stmt->execute(array($category_name,$category_description,$id));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}

/* category function ends here */

/* stock available function starts here */
function get_stock_available(){
    global $db;
    try{
    $sql = "SELECT * FROM stock_details where status = 'active' and stock_quatity > 0";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}
//print_r (get_stock_available());

/* supplier related functions start here */


/* supplier related function end here */

function table_counter($table_name){
    global $db;
  
    try {
        $stm = $db->prepare("SELECT * FROM $table_name");
        $stm->execute();
        $stm->fetchAll(PDO::FETCH_ASSOC);
        $counter = $stm->rowCount();
        if($counter>0){
            $rslt=$counter;
        }
        else{
            $rslt=0;
        }
      
    } catch (PDOExcepion $ex) {
        $rslt = $ex->getMessage();
    }
    return $rslt;
}

/* supplier fuctions */
function create_supplier($supplier_name,$supplier_address,$supplier_contact){
  global $db;
  try{
      $stmt = $db->prepare("insert into supplier_details(supplier_name,supplier_address,supplier_contact1) values(?,?,?
	  )");
      $stmt->execute(array($supplier_name,$supplier_address,$supplier_contact));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}

function get_all_suppliers(){
    global $db;
    try{
    $sql = "SELECT * FROM supplier_details";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

/* store details functions starts here */
function get_store_details(){
    global $db;
    try{
    $sql = "SELECT * FROM store_details";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}
//print_r (get_store_details());

/* store details */
function get_store_det($sid){
    global $db;
    try{
    $sql = "SELECT * FROM store_details where id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($sid));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}


function edit_store_details($name,$address,$city,$phone,$email,$tax_condition,$vat,$bpn,$id){
  global $db;
  try{
      $stmt = $db->prepare("update store_details set name=?,address=?, city=?, phone=? ,email=?, tax_condition=?, vat=?, bpn=? where id=?");
      $stmt->execute(array($name,$address,$city,$phone,$email,$tax_condition,$vat,$bpn,$id));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}


function update_store_logo($pic_path,$id)
{
     global $db;
  try{
      $stmt = $db->prepare("update store_details set log=? where id=?");
      $stmt->execute(array($pic_path,$id));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}


//  purchase stocks

// log stock qty
function stock_log($prodCode,$Qty,$type){
    global $db;
  try{
      $stmt = $db->prepare("insert into stock_movement(ProductCode,Quantity,Type,CreatedBy) values(?,?,?,?)");
      $stmt->execute(array($prodCode,$Qty,$type,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;
}

//update stock details available qty
function update_stock_held($code,$totalQty){
    global $db;
  try{
      $stmt = $db->prepare("update stock_details set stock_quatity=stock_quatity+? where stock_id=?");
      $stmt->execute(array($totalQty,$code));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result; 
}

//update stock details available qty
function reduce_stock_held($code,$totalQty){
    global $db;
  try{
      $stmt = $db->prepare("update stock_details set stock_quatity=stock_quatity-? where stock_id=?");
      $stmt->execute(array($totalQty,$code));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result; 
}

// set transaction list - set values for aging reasons  -  transaction_list_age_data
function set_transaction($supp_debtor_name,$trnasRef,$trans_type,$transDate,$transAmnt,$transClass){
   global $db;
  try{
      $stmt = $db->prepare("insert into transaction_list_age_data(Supp_Cust_Name,transID,Trans_Type,Transaction_Date,Trans_Amount,Trans_Class,Created_By) values(?,?,?,?,?,?,?)");
      $stmt->execute(array($supp_debtor_name,$trnasRef,$trans_type,$transDate,$transAmnt,$transClass,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function create_purchase($stock_id,$stock_name,$supplier,$category,$qty,$opening_stock,$closing_stock,$companyPrice,$sellingPrice,$line_total,$paymentMode,$actual_payment,$oustanding_bal,$status,$due_date,$type,$REFID){
 global $db;
  try{
      $stmt = $db->prepare("insert into stock_entries(stock_id,stock_name,stock_supplier_name,category,quantity,Opening_Stock,Closing_Stock,company_price,selling_price,total,mode,payment,balance,status,due_date,type,transID,DoneBy) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute(array($stock_id,$stock_name,$supplier,$category,$qty,$opening_stock,$closing_stock,$companyPrice,$sellingPrice,$line_total,$paymentMode,$actual_payment,$oustanding_bal,$status,$due_date,$type,$REFID,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function update_supplier_balance($bal,$name){
       global $db;
  try{
      $stmt = $db->prepare("update supplier_details set balance=balance+? where supplier_name=?");
      $stmt->execute(array($bal,$name));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function  set_transaction_debtor_age_data($debtor_name,$trnasRef,$trans_type,$transDate,$transAmnt,$transClass){
   global $db;
  try{
      $stmt = $db->prepare("insert into transaction_list_debtorage_data(CustomerName,transID,TransType,TransDate,TransAmnt,TransactionClass,Logged_by) values(?,?,?,?,?,?,?)");
      $stmt->execute(array($debtor_name,$trnasRef,$trans_type,$transDate,$transAmnt,$transClass,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function update_debtor_balance($bal,$name){
       global $db;
  try{
      $stmt = $db->prepare("update customer_details set balance=balance+? where customer_name=?");
      $stmt->execute(array($bal,$name));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function reduce_debtor_bal($bal,$name){
    global $db;
  try{
      $stmt = $db->prepare("update customer_details set balance=balance-? where customer_name=?");
      $stmt->execute(array($bal,$name));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;    
}

function create_sale($rec_no,$customer,$stock_code,$prod_name,$category,$tax_code,$price,$sell_qty,$line_total,$grand_total,$discount_amnt,$payable_amount,$actual_paid,$balance,$due_date,$payment_mode,$sale_status){
    global $db;
  try{
      $stmt = $db->prepare("insert into stock_sales(rec_no,customer,stock_id,stock_name,category,Tax_Code,selling_price,quantity,subtotal,grand_total,dis_amount,payable_amount,payment,balance,due_date,payment_mode,CreatedBy,status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute(array($rec_no,$customer,$stock_code,$prod_name,$category,$tax_code,$price,$sell_qty,$line_total,$grand_total,$discount_amnt,$payable_amount,$actual_paid,$balance,$due_date,$payment_mode,$_SESSION["id"],$sale_status));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function create_receipt_header($rec_no,$customer,$grand_total,$discount_amnt,$payable_amount,$actual_paid,$outstandings,$payment_mode,$status){
   global $db;
  try{
      $stmt = $db->prepare("insert into Receipt_header_info(Receipt_no,Customer,NetValue,TotalDiscount,Payable_amount,Actual_Payment,Outstanding_balance,payment_mode,Status,CreatedBy) values(?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute(array($rec_no,$customer,$grand_total,$discount_amnt,$payable_amount,$actual_paid,$outstandings,$payment_mode,$status,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;    
}

function get_all_sales(){
    global $db;
    try{
    $sql = "SELECT * from Receipt_header_info";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}


function get_distinct_cat(){
 global $db;
    try{
    $sql = "SELECT distinct(category) FROM stock_details";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

/** cancel or return products sold product
 * affects:
 * 1. stock_sales - done
 * 2. receipt header info - done
 * 3. stock_qty - use update_stock_held() to add qty if return type is stock valid 
 * 4. Stock Movement - stock_log() - done
 * 5. Customer detail if sale was on credit - update customer balance (update_debtor_balance()) with net effect if sale was done not on cash
 * 6. transaction_list_debtorage_data - set_transaction_debtor_age_data();
 * 
 */

function update_salesheader_on_return($status,$reason,$rec_no){
    global $db;
  try{
      $stmt = $db->prepare("update receipt_header_info set status=?,LastUpdateBy=?,LastUpdatedReason=? where Receipt_no=?");
      $stmt->execute(array($status,$_SESSION["id"],$reason,$rec_no));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function update_salesitems_on_return($status,$rec_no){
    global $db;
  try{
      $stmt = $db->prepare("update stock_sales set status=?,Who_to_status=? where rec_no=?");
      $stmt->execute(array($status,$_SESSION["id"],$rec_no));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
}

function get_trans_products($rec_no){
   global $db;
    try{
    $sql = "SELECT * FROM stock_sales where rec_no=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($rec_no));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

function update_signature($signature,$receiptNo){
    global $db;
     try{
      $stmt = $db->prepare("update receipt_header_info set fiscal_signature=? where Receipt_no=?");
      $stmt->execute(array($signature,$receiptNo));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;  
    
}

function get_stock_cat($cat_name){
    global $db;
    try{
    $sql = "SELECT * FROM stock_details where status ='active' and category=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($cat_name));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

//audit trail and product summary

function create_prod_audit($desc,$prodID){
    global $db;
  try{
      $stmt = $db->prepare("insert into  prod_audit(Description,prod_id,DoneBy) values(?,?,?)");
      $stmt->execute(array($desc,$prodID,$_SESSION["id"]));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
          $result["id"]=$db->lastInsertId();
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result;    
}

function get_sku_det($pid){
     global $db;
    try{
    $sql = "SELECT * FROM prod_audit where prod_id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($pid));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

function get_inv_qty($inv_num){
  global $db;
    try{
    $sql = "SELECT sum(quantity) as ttl_qty FROM stock_sales where rec_no=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($inv_num));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;      
}



function get_pos_responses($wezhaz){
  global $db;
    try{
    $sql = "SELECT * FROM pos_response where response_code = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($wezhaz));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;      
}
//print_r (get_pos_responses("00"));


//swipe count down
function get_swipe_countdown(){
     global $db;
    try{
    $sql = "SELECT seconds FROM swipe_countdown";
    $stmt = $db->prepare($sql);
    $stmt->execute(array());
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}
//print_r (get_swipe_countdown());

function get_swipe_details($id){
  global $db;
    try{
    $sql = "SELECT * FROM swipe_countdown where id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;      
}
//print_r (get_swipe_details("1"));


//update swipe count down

function edit_swipe_details($seconds){
    global $db;
  try{
      $stmt = $db->prepare("update swipe_countdown set seconds=? ");
      $stmt->execute(array($seconds));
      $counter = $stmt->rowCount();
      if($counter>0){
          $result["status"]="ok";
         
      }
      else{
          $result["status"]="error";
      }
  } catch (Exception $ex) {
      $result["status"]=$ex->getMessage();
  }
  return $result; 
}

