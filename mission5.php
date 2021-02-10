<?php
//接続
$dsn ='データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
//テーブル作成(名前；tb)
$sql = "CREATE TABLE IF NOT EXISTS tb"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "pass TEXT"
	.");";
	$stmt = $pdo->query($sql);

//編集してかきこみ3
if(!empty($_POST["name"])&&!empty($_POST["com"]) ) 
   {if(!empty($_POST["pnum"])&&!empty($_POST["pass1"]))
    {$id3 = $_POST["pnum"]; //変更する投稿番号
	  $name3 = $_POST["name"];
	  $comment3 = $_POST["com"];
	  $pass3 = $_POST["pass1"]; 
	
	  $sql3 = 'UPDATE tb SET name=:name,comment=:comment,pass=:pass WHERE id=:id';
	  $stmt3 = $pdo->prepare($sql3);
	  $stmt3->bindParam(':name', $name3, PDO::PARAM_STR);
	  $stmt3->bindParam(':comment', $comment3, PDO::PARAM_STR);
	  $stmt3->bindParam(':pass', $pass3, PDO::PARAM_STR);
	  $stmt3->bindParam(':id', $id3, PDO::PARAM_INT);
	  $stmt3->execute();}


//テーブルに書き込み1
  elseif(empty($_POST["pnum"])&&!empty($_POST["pass1"]))
   {$sql1 = $pdo -> prepare("INSERT INTO tb (name, comment, pass) VALUES (:name, :comment, :pass)");
	$sql1 -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql1 -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql1 -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["com"];
	$pass=$_POST["pass1"]; //pass=pas
	$sql1 -> execute();}}
	
//編集番号の受け取り2
 if(isset($_POST["pro"]) && isset($_POST["pass3"]))
    {$sql2 = 'SELECT * FROM tb';
	 $stmt2 = $pdo->query($sql2);
	 $results2 = $stmt2->fetchAll();
	 foreach ($results2 as $row2){
     if($_POST["pass3"]==$row2['pass']&&$_POST["pro"]==$row2['id'])//データ抽出後pass比較
	    {$p=$row2['id'];
	     $pname=$row2['name'];
	     $pcom=$row2['comment'];
	    }}}
	
//削除4
if(isset($_POST["del"]) && $_POST["del"]!="") 
  {$sql4 = 'SELECT * FROM tb';
	 $stmt4 = $pdo->query($sql4);
	 $results4 = $stmt4->fetchAll();
	 foreach ($results4 as $row4)
	 {if($row4['pass']==$_POST["pass2"]&&$row4['id']==$_POST["del"])
    $id4 = $_POST["del"];//ここに番号
	$sql4 = 'delete from tb where id=:id';
	$stmt4 = $pdo->prepare($sql4);
	$stmt4->bindParam(':id', $id4, PDO::PARAM_INT);
	$stmt4->execute();}}


//書き込み内容表示5
	$sql5 = 'SELECT * FROM tb';
	$stmt5 = $pdo->query($sql5);
	$results5 = $stmt5->fetchAll();
	foreach ($results5 as $row5){
		//$rowの中にはテーブルのカラム名が入る
		echo $row5['id'].',';
		echo $row5['name'].',';
		echo $row5['comment'].',';
		echo $row5['pass'].'<br>';
	echo "<hr>";
	}
	
?>

<head>
     <meta charset=utf-8>
      <!--名前コメントフォーム-->
     <form action="" method="post">
        <input type="hidden" name="pnum" value="<?php echo $p; ?>"><br>
        <input type="txt" name="name" placeholder="名前" value="<?php echo $pname; ?>"> 
        <input type="txt" name="com" placeholder="コメント" value="<?php echo $pcom; ?>"> <br>
        <input type="txt" name="pass1" placeholder="パスワード">
        <input type="submit" name="submit">
    </form>
     
    <!--削除フォーム-->
     <form action="" method="post">
        <input type="number" name="del"  placeholder="削除"><br>
        <input type="txt" name="pass2" placeholder="パスワード">
        <input type="submit" name="submit" value="削除">
    </form>
    
    <!--編集フォーム-->
      <form action="" method="post">
        <input type="number" name="pro" placeholder="編集" ><br>
        <input type="txt" name="pass3" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
    </form>
    </head>