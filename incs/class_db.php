<?php

    class dblib {
        //Biến lưu trữ kết nối
        private $__conn;

        //Hàm kết nối
        function connect(){
            //Thông tin database
            $servername = "localhost";
            $username = "root";
            $password = "123456";
            $dbname = "webtintuc";

            //Kiểm tra kết nối thì thực hiện kết nối
            if (!$this->__conn){
                //Kết nối
                try{
					$this->__conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					$this->__conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                    die();
                }
            }
        }

        //Hàm ngắt kết nối
        function dis_connect(){
            //Nếu đang kết nối thì ngắt
            if ($this->__conn){
                $this->__conn = null;
            }
        }

        //Hàm insert
        function insert($table, $data){

            $this-> connect();

            //Lưu trữ danh sách field
            $field_list = '';

            //Lưu trữ danh sách giá trị tương ứng với field
            $value_list = '';

            //Lặp qua data
            foreach($data as $key => $value){
                $field_list .= ",$key";
			    $value_list .= ",N'".$value."'";
            }

            // Vì sau vòng lặp các biến $field_list và $value_list sẽ thừa một dấu , nên ta sẽ dùng hàm trim để xóa đi
		    $sql = 'INSERT INTO '.$table. '('.trim($field_list, ',').') VALUES ('.trim($value_list, ',').')';
		    $stmt = $this->__conn->prepare($sql);
		
		    return $stmt->execute();
        }

        // Hàm Update
	    function update($table, $data, $where)
	    {
		    // Kết nối
		    $this->connect();
		    $sql = '';
		    // Lặp qua data
		    foreach ($data as $key => $value){
			    $sql .= "$key ='".$value."',";
		    }
		    // Vì sau vòng lặp biến $sql sẽ thừa một dấu , nên ta sẽ dùng hàm trim để xóa đi
		    $sql = 'UPDATE '.$table. ' SET '.trim($sql, ',').' WHERE '.$where;
		    $stmt = $this->__conn->prepare($sql);
		
		    return $stmt->execute();
	    }
	
	    // Hàm delete
	    function remove($table, $where){
		    // Kết nối
		    $this->connect();
		
		    // Delete
		    $sql = "DELETE FROM $table WHERE $where";
		    $stmt = $this->__conn->prepare($sql);
		
		    return $stmt->execute();
	    }
	
	    // Hàm lấy danh sách
	    function get_list($sql)
	    {
		    // Kết nối
			$this->connect();
		    // Thực hiện lấy dữ liệu
		    $stmt = $this->__conn->prepare($sql);
		    $stmt->execute();
		    $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    return $stmt->fetchALL();
	    }
	
	    // Hàm lấy 1 record duy nhất
	    function get_row($sql)
	    {
		    // Kết nối
		    $this->connect();
		
		    // Thực hiện lấy dữ liệu
		    $stmt = $this->__conn->prepare($sql);
		    $stmt->execute();
		    $stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		    return $stmt->fetch();	
		}
		
		//get row number
		function get_row_number($sql){
			$this-> connect();

			$stmt = $this->__conn->prepare($sql);
			$stmt->execute();

			return $stmt->fetchColumn();
		}
    }
?>
