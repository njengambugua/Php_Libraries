<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <style>
    *{
      margin: 0;
      padding: 0;
      text-align: center;
    }
    .navigation-bar{
      list-style: none;
    }
    body{
      background-color: rgba(56, 13, 117, 0.755);
      height: 100vh;
      width: 100%;
    }
    li{
      float: left;
      margin-left: 12.5%;
    }
    li a{
      font-size: 1.5rem;
      font-weight: 400;
      color: white;
    }
    li a:hover{
      text-transform: uppercase;
      color: orange;
    }
    button{
      background: rgba(240, 158, 5, 0.859);
      color: white;
      width: 9em;
      height: 3em;
    }
    .nav{
      height:10%;
    }
    .image-holder{
      width: 50%;
      height: 50%;
      position: absolute;
      transform: translate(-50%, -50%);
      top: 50%;
      left: 50%;
    }
    img{
      width: 100%;
      height: 75%;
    }
  </style>
</head>
<body>
  <div class="nav">
    <ul class="navigation-bar">
      <li><a>Home</a></li>
      <li><a>About</a></li>
      <li><a>Products</a></li>
      <li><a>Contacts</a></li>
    </ul>
  </div>

  <div class="image-holder">
    <img src="./images/print.jpg" alt="">
    <button class="print">PRINT</button>
  </div>
  <script>
    const print = document.querySelector('.print');
    print.addEventListener('click', ()=>{
      window.location.href = "./index.php";
    })
  </script>
</body>
</html>