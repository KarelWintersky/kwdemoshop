<?php
require_once "../lib_core.php";

$ref_name = IsSet($_GET["name"]) ? ($_GET["name"]) : "test";
$ref_prompt = IsSet($_GET["prompt"]) ? ($_GET["prompt"]) : $ref_name;
$link = ConnectDB();

$query = "SELECT id,data FROM $ref_name";
$res = mysql_query($query) or die("Невозможно получить содержимое справочника!".$ref_name);
$numrows = mysql_num_rows($res);
for ($i=0;$i<$numrows;$i++)
{
    $ref_record = mysql_fetch_assoc($res);
    $id = $ref_record["id"];
    $ref_data[$id] = $ref_record["data"];
}
CloseDB($link);
?>
<head>
    <title>Работа со справочником: <?php echo $ref_name; ?></title>
    <style type="text/css">
        td { text-align: center;}
        tr { vertical-align: middle; }
    </style>
    <script>
        function makeRequest(url,control) {
            var httpRequest = false;

            if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                httpRequest = new XMLHttpRequest();
                if (httpRequest.overrideMimeType) {
                    httpRequest.overrideMimeType('text/xml');
                }
            } else if (window.ActiveXObject) { // IE
                try {
                    httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {}
                }
            }

            if (!httpRequest) {
                alert('Не вышло :( Невозможно создать экземпляр класса XMLHTTP ');
                return false;
            }
            httpRequest.onreadystatechange = function() { alertContents(httpRequest,control); };
            httpRequest.open('GET', url, true);
            httpRequest.send(null);
        }

        function alertContents(httpRequest,control) {

            if (httpRequest.readyState == 4) {
                if (httpRequest.status == 200) {
                    control.innerHTML = httpRequest.responseText;
                } else {
                    alert('С запросом возникла проблема.'+httpRequest.url);
                }
            }

        }
        function confirm_purge(id,targ) {
            if (confirm('Вы уверены, что хотите удалить запись с номером '+id+' ?'))
            {
                req = 'ref_action_purge.php?id='+id+'&name=<?php echo $ref_name ?>';
                t = document.getElementById(targ);
                makeRequest(req,document.getElementById(targ));
                return false;
            }
        }
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
            var  rnd982g  =  randomnumber=Math.floor(Math.random()*101)
            if (ajax != null)
            {
                ajax.open("POST",file,true);

                // если параметров несколько, то они разделяются &
                param="value="+document.getElementById('new_value').value;
                param+="&name=<?php echo $ref_name; ?>";
                param+="&rnd982g="+rnd982g;
                param+="&reload=this";
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
                }
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
//            window.reload();
                } else document.getElementById("results").innerHTML  = x_request.status+" - "+x_request.statusText;
            }
        }
        function Init()
        {
            document.getElementById("new_value").value="";
        }

    </script>
</head>
<body onLoad="Init()">
<table border="1" width="40%">
    <tr><td>Справочник</td></td><td colspan="3"><?php echo $ref_prompt;?></td></tr>
    <tr><td>Записей:</td><td colspan="3"><?php echo $numrows;?></td></tr>
    <tr><td colspan="4"><hr width="80%"></td></tr>
    <tr>
        <td align="center">id</td>
        <td>данные</td>
        <td colspan="2">Управление</td>
    </tr>
    <?php
    if ($numrows)
        foreach ($ref_data as $i=>$v) {
            ?>
            <tr>
                <td id="id_<?php echo $i; ?>"><?php echo $i; ?></td>
                <td id="v_<?php echo $i; ?>"><?php echo $v; ?></td>
                <td id="e_<?php echo $i; ?>"><a href="javascript://" onClick="window.open('ref_edit.php?id=<?php echo $i; ?>&ref=<?php echo $ref_name?>','Редактирование элемента справочника <?php echo $ref_name?>','scrollbars=1,width=830,height=200,top=160,left=60')"><img src="edit.png" border="0"></a></td>
                <td id="d_<?php echo $i; ?>"><a href="javascript://" onClick="return confirm_purge(<?php echo $i ?>,'id_<?php echo $i; ?>')"><img src="stop.png" border="0"></a></td>
            </tr>
            <?php
        } else echo '<tr><td colspan="4">Справочник пуст!</td></tr>';
    ?>
    <tr>
        <td>
            <a href="javascript://" onClick="window.open('ref_add.php?ref=<?php echo $ref_name?>','Добавление в справочник: <?php echo $ref?>','scrollbars=1,width=830,height=200,top=160,left=60')"><img src="add.png" border="0"></a>
        </td>
        <td colspan="3">
            <a href="javascript://" onClick="window.open('ref_add.php?ref=<?php echo $ref_name?>','Добавление в справочник: <?php echo $ref?>','scrollbars=1,width=830,height=200,top=160,left=60')">Добавление элемента</a>
        </td>
    </tr>
</table>
<br>
<form>
    <input type="hidden" name="X_user_id" value="<?php echo $_SESSION["user_id"];?>">
    <input type="hidden" name="X_caller" value="user">

    <div class="main">
        <div class="field">
            <label for="new_value">Новое значение: </label>
            <input type="text" name="new_value" id="new_value" />
            <input  type="button" id="quest_button" value="Добавить данные"  onClick="ajaxFunction(this.form,'ref_action_insert.php');return false;">
        </div>
    </div>
</form>
<div id="results">
    <input type="button" value="Обновить страницу" onClick="window.location.href=window.location.href">  </div>
<br>

</body>
</html>
