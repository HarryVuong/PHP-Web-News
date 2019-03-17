<?php

    if(isset($_GET["btnSearch"])){
        $getTitle = $_GET["titleSearch"];
        $sql = "SELECT count(*) FROM posts WHERE title LIKE '%$getTitle%'";

        $total_records = $homelib->get_row_number($sql);

        $limit = 3;

	    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
	    $total_page = ceil($total_records / $limit);
	    if ($current_page > $total_page){
		    $current_page = $total_page;
	    }else if ($current_page < 1){
		    $current_page = 1;
	    }

        $start = ($current_page - 1) * $limit;
        $start = $start < 0 ? 0 : $start; //check if total_records is null

        $sql = "SELECT * FROM posts WHERE title LIKE '%$getTitle%' ORDER BY createdate DESC LiMIT $start, $limit";
        $data = $homelib->get_list($sql);
    }
    else {
        $where = '';
        if(isset($_GET['cate'])){
            $cate = intval($_GET['cate']);
        if($cate != 0)
            $where = "WHERE category_id = $cate";
        }

        //Phân trang
	    $sql = "SELECT count(*) FROM posts $where";
        $total_records = $homelib->get_row_number($sql);
    
	    $limit = 3;

	    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
	    $total_page = ceil($total_records / $limit);
	    if ($current_page > $total_page){
		    $current_page = $total_page;
	    }else if ($current_page < 1){
		    $current_page = 1;
	    }

        $start = ($current_page - 1) * $limit;
        $start = $start < 0 ? 0 : $start; //check if total_records is null

        $sql = "SELECT * FROM posts $where ORDER BY createdate DESC LiMIT $start, $limit";
        $data = $homelib->get_list($sql);
    }
    
?>

  <!-- Blog Entries Column -->
            <div class="col-md-8" id="showPost">

                <h3 class="my-4"><?php
                    if(isset($getTitle)) { ?>
                        Kết quả tìm kiếm: <?php echo $getTitle; ?>
                    <?php } if(isset($cate)) { ?>
                        Kết quá tìm kiếm theo chủ đề:
                    <?php } ?>
                </h3>

                <!-- Blog Post -->
                <?php
                    for($i=0; $i<count($data); $i++){
                    ?>                   
                    <div class="card mb-4">
                    <img class="card-img-top" src="./images/<?php echo $data[$i]['image']; ?>" height="300" width="750" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $data[$i]['title']; ?></h2>
                        <p class="card-text"><?php echo substr($data[$i]['content'], 0, 154).'.....'; ?></p>
                        <a href="detail.php?post_id=<?php echo $data[$i]['post_id'] ?>" class="btn btn-primary">Đọc tin &rarr;</a>
                    </div>
                    </div>

                    <?php
                    }
                ?>

                <!-- Phân trang -->
				<ul class="pagination justify-content-center mb-4">
					
					<?php
						if ($current_page > 1 && $total_page > 1){
							echo '<li class="page-item"><a class="page-link" href="index.php?page='. ($current_page - 1) .'">Prev</a></li>';
						}
						for($i=1; $i<=$total_page; $i++){
							if ($current_page == $i)
								echo '<li class="page-item disabled"><a class="page-link" href="#">'.$i.'</a></li>';
							else
								echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
						}

						if ($current_page < $total_page && $total_page > 1){
							echo '<li class="page-item"><a class="page-link" href="index.php?page='. ($current_page + 1) .'">Next</a></li>';
						}
					?>

				</ul>

            </div>
