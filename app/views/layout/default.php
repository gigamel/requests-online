<?php
use vendor\ASh\Url\UrlManager;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $TITLE_VIEW ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
      integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
      crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/style.css">
  </head>
  <body>
    <div class="header">
      <div class="container">
        <div class="row">
          <div class="col">
            <a href="/" class="logo">РосЗапись</a>
          </div>
          <div class="col text-right">
            <a href="<?= UrlManager::link('request/manager'); ?>"
              class="btn btn-secondary">Менеджер записей</a>
          </div>
        </div>
      </div>
    </div>
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col">
            <?= $CONTENT_VIEW ?>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    /*$(document).ready(function(e) {
      
      function enterValidPhone(e) {
        if ((e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8 || e.keyCode == 13) {
            if ($(this).val().length == 1) {
                $(this).val($(this).val() + ' (');
            }
            
            if ($(this).val().length == 6) {
                $(this).val($(this).val() + ') ');
            }
            
            if ($(this).val().length == 11) {
                $(this).val($(this).val() + '-');
            }
            
            if ($(this).val().length == 14) {
                $(this).val($(this).val() + '-');
            }
        } else {
            e.preventDefault();
            return false;
        }
      };
      
      $('.regex_phone').keydown(enterValidPhone);
      $('.regex_phone').keyup(enterValidPhone);
      
    });
    
    
    $('form').first().submit(function(e) {
        var _ajaxForm = $(this),
            _ajaxData = _ajaxForm.serialize();
        
        $.ajax({
            url: '/',
            method: 'POST',
            data: _ajaxData,
            success: function(response) {
                _ajaxForm.html($(response).find('form').first().html());
            },
            error: function(response) {
                console.log(response);
            }
        });
        
        e.preventDefault();
        return false;
    });*/
    
    </script>
  </body>
</html>