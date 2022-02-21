<?php include "vurl.php";
if($vi == "" || $vi == "tos" || $vi == "report"){ ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width" />
<title>Od.dyn</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Redacted&display=swap');
  h1 a {
    font-family: "Press Start 2P", sans-serif;
    color: black;
  }
  body {
    text-align: center;
    font-family: sans-serif;
    text-decoration: none;
  }
  .container {
    margin: 10px 25%;
    border: solid 2px black;
    border-radius: 2px;
    padding: 10px;
  }
  #tos p, #tos ul {
    text-align: initial;
  }
</style>
</head>
<body>
<h1><a href="/">Od.dyn</a><span style="font-weight:normal;font-size:medium"><br />URL shortener</span></h1>
<?php if($vi == ""){
  if(isset($_POST["url"])){
    $ch = curl_init();
    $data = array(
      "url"=>$_POST["url"]
    );
        
    curl_setopt($ch, CURLOPT_URL, $_ENV["backend"]."/new");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if($response){
      $response = json_decode($response);
      if(!$response->{"error"}){
        $msg = '<p><a href="http://od.dyn/'.$response->{"url"}.'">http://od.dyn/'.$response->{"url"}.'</a></p>';
      }else{
        $msg = '<p style="color:red">';
        if($response->{"code"}==2){
          $msg = $msg."Required scopes missing";
        }elseif($response->{"code"}==4){
          $msg = "<p>We're not currently accepting new URLs to shoten";
        }else{
          $msg = $msg."Error";
        }
        $msg = $msg."</p>";
      }
    }
  }else{$msg="";} ?>
<div>
  <form method="POST">
    <input type="url" name="url" placeholder="Long URL" required />
    <input type="submit" value="Short" />
    <?= $msg ?>
    <p style="font-size:small">By submiting this URL, you accept <a href="/tos">Od.dyn's Terms of Service</a>.</p>
  </form>
</div>
<?php }elseif($vi == "tos"){ ?>
<div class="container" id="tos">
  <h2>Od.dyn's Terms of Service</h2>
  <h3>Before getting started</h3>
  <p>When we refer as "we", "our" or "us", we're talking about principally Luqaska, but also our third party companies that help hosting this service. And when we will refer as "you" or "user(s)", we are talking about, you as a user.</p>
  <h3>What we expect you to do</h3>
  <p>We espect you to not use this service for short URLs...</p>
  <ul>
    <li>...with content illegal on the United States of America and/or the Argentine Republic</li>
    <li>...that have NSFW material, such as porn websites, or gore/gore-related material.</li>
  </ul>
  <h3>Responsability</h3>
  <p>We, are not responsible for any action you could execute, at the hour of using our platform. We reserve the right to delete any URL short made using our service, at any time, without any previous warranty.</p>
</div>
<?php }elseif($vi == "report"){ ?>
<div class="container" id="report">
  <h2>Report a link</h2>
<?php if(isset($_POST["url"]) && isset($_POST["why"])) {
  $ch = curl_init();
    $data = array(
      "report"=>"http://od.dyn/" . $_POST["url"] . "\n" . $_POST["why"]
    );

    curl_setopt($ch, CURLOPT_URL, $_ENV["backend"]."/report");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    echo '<p><b>Done!</b> Thank you for your report!</p>';
  }else{ ?>
  <form method="POST">
    http://od.dyn/<input type="number" name="url" style="width:80px" placeholder="ID" required /><br />
    <textarea name="why" placeholder="Why? (optional)"></textarea><br />
    <input type="submit" value="Report" />
  </form>
<?php } ?>
</div>
<?php } ?>
<footer><a href="https://github.com/luqaska/od.dyn-frontend">Code</a> - <a href="/report">Report URL</a> - <a style="font-family:'Redacted'" href="/3">Trolling</a></footer>
</body>
</html>
<?php }else{
    $ch = curl_init();
    $data = array(
      "id"=>$vi
    );
        
    curl_setopt($ch, CURLOPT_URL, $_ENV["backend"]."/url");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if($response){
      $response = json_decode($response);
      if(!$response->{"error"}){
        header("location: ".$response->{"url"});
      }else{
        header("location: /404.html");
      }
    }
}
