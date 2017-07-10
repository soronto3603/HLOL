<html>
  <head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/hlol.css">
  </head>
  <body>
    <div class="light_box" id=loading_image style="display:none">
      <div class="light_box_tm"></div>
      <center>
        <div class="light_box_ct"></div>
        <img src="Pacman.gif">
        <h1 class="col_back">Loading...</h1>
      </center>
    </div>
    <div class="navi_contanier">
      <div class="navi_item">My Summoner Name</div>
      <div class="navi_item">
        <input type=text id=src_nickname>
      </div>
      <button onclick="detect_text(document.getElementById('src_nickname'));">결과</button>
      <div class="navi_item">RESULT</div>
      <div class="navi_item navi_result" id=src_result>Nothing</div>
      <div class="navi_item">　</div>
      <div class="navi_item">Anothor Summoner Name</div>
      <div class="navi_item">
        <input type=text id=dst_nickname>
      </div>
      <button onclick="detect_text(document.getElementById('dst_nickname'));">결과</button>
      <div class="navi_item">RESULT</div>
      <div class="navi_item navi_result" id=dst_result>Nothing</div>
    </div>
    <div class="content_container" id=content>
      <h1>HLOL</h1>
      <button onclick="start_calc();">계산</button>
    </div>
    <script src="js/hlol.js"></script>
  </body>
</html>
