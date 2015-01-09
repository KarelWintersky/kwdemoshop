<?php
require_once "../lib_core.php";
// получаем $ref - откуда редактировать
$ref_name = IsSet($_GET["ref"]) ? $_GET["ref"] : "test";
$id = $_GET["id"];
//

$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$query = "SELECT id,data FROM $ref_name WHERE id=$id";
$res = mysql_query($query) or die("Невозможно получить содержимое справочника!".$ref_name);
$ref_record = mysql_fetch_assoc($res);
$id = $ref_record["id"];
$data = $ref_record["data"];
$magic = $ref_record["magic"];
CloseDB($link);
?>
<head>
    <style type="text/css">
        body {font-size:14px;}
        label {float:left; padding-right:10px;}
        .field {clear:both; text-align:right; line-height:25px;}
        .main {float:left;}
    </style>
    <script>
        // закрывает себя и обновляет родителя
        function RefreshAndClose(it)
        {
            opener.location.reload();
            window.close();
        }

        function getAjax()
        {
            if (window.ActiveXObject) // для IE
                return new ActiveXObject("Microsoft.XMLHTTP");
            else if (window.XMLHttpRequest)
                return new XMLHttpRequest();
            else {
                alert("Browser does not support AJAX.");
                return null;
            }
        }

        function ajaxFunction(frm,file)
        {
            ajax=getAjax();
            var param;
            var  rnd982g  =  randomnumber=Math.floor(Math.random()*101);
            if (ajax != null)
            {
                ajax.open("POST",file,true);

                // если параметров несколько, то они разделяются &
                param="value="+encodeURIComponent(document.getElementById('new_value').value);
                param+="&name=<?php echo $ref_name; ?>";
                param+="&rnd982g="+rnd982g;
                param+="&reload=parent";
                param+="&id=<?php echo $id; ?>";
                // добавляем стандартный заголовок http посылаемый через ajax
                ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");

                // вроде эти могут тормозить
                ajax.setRequestHeader("Content-length", param.length);
                ajax.setRequestHeader("Connection", "close");
                ajax.onreadystatechange = function(){
                    if(ajax.readyState==4 && ajax.status==200)
                    {
                        response = ajax.responseText;
                        document.getElementById("results").innerHTML=response;
                        document.getElementById("quest_button").disabled=true;
                    }
                };
                // посылаем наши данные или пустую строку (param="") главное не null
                ajax.send(param);
            }
        }

        function  handleResponse()
        {
            if(x_request.readyState  ==  4)
            {
                if (x_request.status == 200)
                {
                    document.getElementById("results").innerHTML  =  x_request.responseText;
                    x_request.abort();
                } else document.getElementById("results").innerHTML  = x_request.status+" - "+x_request.statusText;
            }
        }

    </script>
</head>
<body>
<form>
    <input type="hidden" name="X_user_id" value="<?php echo $_SESSION["user_id"];?>">
    <input type="hidden" name="X_caller" value="user">
    <input type="hidden" name="X_magic" value="<?php echo $magic; ?>">
    <div class="main">
        <div class="field">
            <label for="new_value">Значение: </label>
            <input type="text" name="new_value" id="new_value" value="<?php echo $data; ?>"/>
        </div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="button" id="quest_button" value="Обновить данные"  onClick="ajaxFunction(this.form,'ref_action_update.php');return false;">
</form>
<div id="results">
    <input type="button" name="return" value="Закрыть окно" onClick="RefreshAndClose(self)">
</div>

</body>