<?php
require_once "../lib_core.php";
$ref_name = IsSet($_GET["ref"]) ? ($_GET["ref"]) : "ref_test";
$ref_prompt = IsSet($_GET["prompt"]) ? ($_GET["prompt"]) : $ref_name;
$link = ConnectDB();
$id = IsSet($_GET["id"]) ? ($_GET["id"]) : "0";
$query = "SELECT data,extdata FROM $ref_name ORDER BY id";
$res = mysql_query($query) or die("Невозможно получить содержимое справочника!".$ref_name);
$record = mysql_fetch_assoc($res);
CloseDB($link);
?>
<style>
    .fixedheight {
        margin-bottom:2em;
        max-height:50em;
        overflow:auto;
    }
</style>
<table border="1" width="100%">
    <tr>
        <td align="right">
            <input type="button" name="Return_to_market" value="X" src="../images/exit.png" onClick="window.close(self);return false;">
        </td>
    </tr>
    <tr>
        <td><input type="text" value="<?php echo $record["data"] ?>" readonly></td>
    </tr>
    <tr>
        <td>
            <?php
            if ($record["extdata"]=="")
                echo '<div style="color:red">Расширенной информации нет</div>';
            else
            {
                echo '
        <div class="fixedheight"><pre>
      ';
                echo $record["extdata"];
                echo '</pre></div>';
            }
            ?>
        </td>
    </tr>
</table>


