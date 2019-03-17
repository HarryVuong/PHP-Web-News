<?php include("header.php");
    $query = $_GET['post_id'];
?>

    <?php 
        if ($query != null) {
            
            $sql = "SELECT * FROM posts WHERE post_id = $query";
            $data = $homelib->get_row($sql); ?>

            <div class="card mb-4">
            <?php if(isset($data['image'])) { ?>
                <img class="card-img-top" src="./images/<?php echo $data['image']; ?>" height="300" width="750" alt="No image">
            <?php } ?>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $data['title'] = isset($data['title']) ? $data['title'] : 'Không tìm thấy kết quả'; ?></h2>
                    <p class="card-text"><?php echo $data['content'] = isset($data['content']) ? $data['content'] : ''; ?></p>
                </div>
            </div>

        <?php } else { ?>

            <div class="card mb-4">
            <div class="card-body">
                    <h2 class="card-title">Không tìm thấy kết quả</h2>
                </div>
            </div>

        <?php } ?>

<?php include("footer.php"); ?>