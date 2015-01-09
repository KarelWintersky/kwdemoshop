<?php
// получаем $ref - куда добавлять
$ref_name = IsSet($_GET["ref"]) ? $_GET["ref"] : "test";

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
            var  rnd982g  =  randomnumber=Math.floor(Math.random()*100001);
            if (ajax != null)
            {
                ajax.open("POST",file,true);

                // если параметров несколько, то они разделяются &
                param="value="+encodeURIComponent(document.getElementById('new_value').value);
                param+="&name=<?php echo $ref_name; ?>";
                param+="&rnd982g="+rnd982g;
                param+="&reload=parent";
                // добавляем стандартный заголовок http посылаемый через ajax
                ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
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
                    var  response  =  x_request.responseText;
                    document.getElementById("results").innerHTML  =  response;
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

    <div class="main">
        <div class="field">
            <label for="new_value">Значение: </label>
            <input type="text" name="new_value" id="new_value" tabindex="1"/>
        </div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="button" id="quest_button" value="Добавить данные"  onClick="ajaxFunction(this.form,'ref_action_insert.php');return false;">
</form>
<div id="results">
    <input type="button" name="return" value="Закрыть окно" onClick="RefreshAndClose(self)">
</div>
<br>Внимание! Дробную часть отделяйте от целой части числа ЗАПЯТОЙ "<b>,</b>"
</body>









