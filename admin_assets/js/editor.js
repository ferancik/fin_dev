jQuery().ready(function() {

    tinymce.init({
        selector: "textarea.tinymceEditor",
        script_url: base_url_original + "admin_assets/plugins/tinymce/tinymce.min.js",
        //theme: "advanced",
        height: "500",
        // width: "100%",
           plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste"
    ],
    toolbar1: "undo redo | styleselect | bold italic strikethrough underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons | formatselect fontselect fontsizeselect | insertlayer",
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]

//        theme: "advanced",
//       // plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
//        theme_advanced_toolbar_location: "top",
//        theme_advanced_toolbar_align: "left",
//        theme_advanced_statusbar_location: "bottom",
//        theme_advanced_resizing: true,
        // Theme options
//        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//        theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
//        // Example content CSS (should be your site CSS)
//        
       // content_css: "" + base_url_original + "assets/css/fontgoogle.css," + base_url_original + "assets/bootstrap/css/bootstrap.css," + base_url_original + "assets/css/template.css," + base_url_original + "admin_assets/css/lomallo_css_hacks.css"
    });
});
  