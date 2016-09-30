<?php
  require_once 'app/init.php';

  $itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items
    WHERE user = :user
  ");

  $itemsQuery->execute(array('user' => $_SESSION['user_id']));

  $items = $itemsQuery->rowCount() ? $itemsQuery : array();

  foreach ($items as $item) {
  	//print_r($item);
  	echo $item['name'], '<br>';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TODO list</title>

	<link href="https://fonts.googleapis.com/css?family=Comfortaa&subset=cyrillic" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/main.css">
  </head>
  <body>
    <div class="list">
    	<h1 class="header">To Do</h1>

    	<?php if (!empty($items)): ?>
    	<ul class="items">
    	    <?php foreach($items as $item): ?>
    		<li>
    		  <span class="item<?php echo $item['done'] ? " done" : "" ?>"><?php echo $item['name']; ?></span>
    		  <?php if(!$item['done']): ?>
    		    <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">mark as done</a>
    		<?php endif; ?>
    		</li>
    		<?php endforeach; ?>
    		<li>
    		  <span class="item"><?php echo "some text"; ?></span>
    		  <a href="#" class="done-button">mark as done</a>
    		</li>
    	</ul>
        <?php else: ?>
        	<p>You haven't added amy items yet</p>
        <?php endif; ?>

    	<form class="item-add" action="add.php" method="post">
    		<input type="text" name="name" placeholder="Type a new item here" class="input" autocomplete="off" required>
    		<input type="submit" value="Add item" class="submit">
    	</form>
    </div>
  </body>
</html>