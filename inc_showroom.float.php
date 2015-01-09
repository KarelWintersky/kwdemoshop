<?php
include "inc_showroom.config.php";
?>

<script>
    function HideDivByRel()
    {
        var divs = document.getElementsByTagName("div");
        // loop through all div tags
        for (var i=0; i<divs.length; i++)
        {
            var adiv = divs[i];
            if (adiv.getAttribute("rel") == "showroom")
            {
                adiv.style.display = 'none';
            }
        }
    }
    function ShowDivByName(divname)
    {
        document.getElementById('district_title_'+divname).style.display = '';
        document.getElementById(divname).style.display = '';
    }

    function ShowList(divname)
    {
        HideDivByRel();
        ShowDivByName(divname);
    }
    function ShowAllByRel()
    {
        HideDivByRel();
        var divs = document.getElementsByTagName("div");
        // loop through all div tags
        for (var i=0; i<divs.length; i++)
        {
            var adiv = divs[i];
            if (adiv.getAttribute("rel") == "showroom")
            {
                adiv_id = adiv.getAttribute("id");
                document.getElementById('district_title_'+adiv_id).style.display = 'none';
                adiv.style.display = 'block';
            }
        }
        return false;
    }
</script>
<style>
    li {
        margin-left: 0px;
        font-weight: 600;
    }
    div.showroom {
        clear:both;
        width:720px;
    }
    li.showroom_a {
        margin-bottom: 7px;
        font-weight: 600;
        font-size: 16px;
    }
    table {
        border: 0px solid black;
    }
    td {
        text-align:center;
        border-collapse: collapse;
    }
    td.l {
        text-align:left;
        padding-top: 8px;
    }
    a {
        cursor: pointer;
    }
    a.lref {
        border-bottom: 2px dotted red;
    }
    a.lref:hover {
        border-bottom: 2px solid red;
    }
        /* td#on_map a:hover {
          border-bottom:2px solid red;
        }  */

    li#select_district a:hover {
        text-decoration: underline;
        color: red;
    }
    th {
        background-color: gold;
    }
</style>

<script type="text/javascript" src="core/hltable.js"></script>

<style>
    .hoverRow {
        background-color: #EBEBEB;
    }
</style>

<div style="width:460px;height:310px;float:left;margin-top:10px" id="GMapContainer">
</div>

<div style="width:260px;float:right;margin-top:10px" id="SR_list">
    <li class="showroom_a">Выберите район города:

        <?php
        foreach ($showrooms as $district_id => $district_cont)
        {
            if ($district_cont['display_in_list'])
                echo '<li class="showroom"><a class="showroom_href" href="javascript://" onClick="ShowList(\''.$district_id.'\')">'.$district_cont['title'].'</a></li>'."\r\n";
        }
        ?>
    <li>&nbsp;</li><li style="font-weight: 600;" id="select_district" class="showroom_a"><a class="hover_ul" href="javascript://" onClick="return ShowAllByRel();CenterMapEmpty(59.9694553,30.2613394,'-',9)">Полный список салонов</a>
</div>

<div style="clear:both;padding-top:5px; padding-right: 40px;"><hr></div>
<table border="0" id="hl_this">
    <tr>
        <td>
            <?php
            foreach ($showrooms as $district_id => $district_cont)
            {
                ?>
                <div class="showroom" id="<?php echo $district_id; ?>" rel="showroom" style="display:none;" title="<?php echo $district_cont['title'];?>">
                    <table border="0" width="100%" bordercolor="red" style="padding-top:4px;padding-bottom:4px" id="hl_this">
                        <tr>
                            <th colspan="3" align="center">
                                <span class="sr_distict_title" style="display:block" id="district_title_<?php echo $district_id;?>"><?php echo $district_cont['title'];?></span>
                            </th>
                        </tr>
                        <?php
                        foreach ($district_cont as $room_id=>$room_info)
                        {
                            if (($room_id!='title')&&($room_id!='coords')&&($room_id!='display_in_list'))
                            {
                                // работаем с room_id=n (номер статьи), room_info к которому является массивом с данными
                                ?>
                                <tr height="<?php echo $sr_image_height; ?>">
                                    <td><img src="<?php echo $image_basepath.$room_info['img'];?>" width="<?php echo $sr_image_width; ?>" height="<?php echo $sr_image_height; ?>"></td>
                                    <td width="71%" style="color: #000000" class="l">
                                        <a href="./core/article_show.php?id=<?php echo $room_id;?>"
                                           onClick="return hs.htmlExpand(this, { width: 500, height:600, objectType: 'ajax', wrapperClassName: 'draggable-header' })">
                                            <div>
                                                <div style="float:left">
                                                    <span><?php echo $room_info['location'];?></span>,&nbsp;
                                                    <?php if (strlen($room_info['metro'])) echo '<nobr>(<span style="color: #0000FF">м. </span>'.$room_info['metro'].')</nobr>'; ?>
                                                    <br>
                                                    <span style="font-weight:bold"><?php echo $room_info['placement'];?></span>
                                                </div>
                                                <div style="float:right">
                                                    <?php echo $room_info['phone'];?>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td width="14%" class="c" id="on_map"><a class="lref" onClick="scroll(0,0);CenterMap(<?php echo $room_info['latitude'];?>,<?php echo $room_info['longitude'];?>,'<?php echo $room_info['title'];?>',<?php echo $room_info['accuracy'];?>)">На Карте</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php
            }
            ?>
        </td>
    </tr>
</table>

<br>
<?php
// а теперь построим галерею
$directory = "core/spaw2/uploads/images/salons/";
if (!is_dir($directory)) mkdir($directory);
$dirhandle = opendir($directory);
while (FALSE !== ($file=readdir($dirhandle)))
{
    if ($file != "." && $file != "..") $all_images[]=$file;
};
closedir($dirhandle);
$v = $all_images[0];
?>

<?php if (count($all_images)) {?>
<script type="text/javascript">
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.outlineType = 'rounded-white';
    hs.fadeInOut = true;
    hs.numberPosition = 'caption';
    hs.dimmingOpacity = 0.75;

    // Add the controlbar
    if (hs.addSlideshow) hs.addSlideshow({
        //slideshowGroup: 'group1',
        interval: 5000,
        repeat: false,
        useControls: true,
        fixedControls: 'fit',
        overlayOptions: {
            opacity: .75,
            position: 'bottom center',
            hideOnMouseOut: true
        }
    });

</script>

<div align="center">
    <div class="highslide-gallery">
        <a id="thumb1" href="<?php echo $directory.$v ?>" class="highslide" onclick="return hs.expand(this, {thumbnailId: 'thumb1', slideshowGroup: 1 })">
            <img src="<?php echo $directory.$v; ?>" alt="Наши салоны" title="Нажмите для увеличения" height="140" width="140"/></a>
        <div class="highslide-caption">&nbsp;</div>
    </div>
    <div class="hidden-container">

        <?php

        foreach ($all_images as $i=>$v)
        {
            if ($i==0) next($all_images);
            else
                echo '<a id="thumb1" href="'.$directory."".$v.'" class="highslide" onclick="return hs.expand(this,{ thumbnailId: \'thumb1\', slideshowGroup: 1 })">
	  <img src="'.$directory."".$v.'" alt="Наши салоны" title="Нажмите для увеличения" height="140" width="140"/></a>
	  <div class="highslide-caption"></div>';
        };
        ?>
    </div>
</div>

<?php } ?>
<script type="text/javascript">
    highlightTableRows("hl_this","hoverRow");
</script>

