<?php

class SPAW_Wysiwyg
{
    private $areaname;
    private $content;
    public function __construct($areaname, $content='')
    {
        $this->areaname = $areaname;
        $this->content = $content;
    }

    public function show()
    {
        printf('
            <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config[\'full\'], \'%s\'); //id!
    </script>', $this->areaname);
        printf('<textarea name="%s" id="%s" cols="10" tabindex="3">%s</textarea>', $this->areaname, $this->areaname, $this->content);
    }
}


?>