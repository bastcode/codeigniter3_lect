<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to makehtml</title>

        <script
            src="https://code.jquery.com/jquery-3.4.0.slim.js"
            integrity="sha256-milezx5lakrZu0OP9b2QWFy1ft/UEUK6NH1Jqz8hUhQ="
        crossorigin="anonymous"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

    </head>
    <body>

        <div id="container">
            <h1>Welcome to makehtml!</h1>
            <div style="width:1100px">
            타이틀 <input type ="text" id="title_main"> 
            <table class='table table-bordered make_talbe'>                
                <tbody>
                    <th> <span>+</span> <span>-</span> </th> <td><input type="text" id="title_sub"> </td> 
                    <td>type [ <button type="button" class="btn btn-success type_text" submit=false>text</button>
                    <button type="button" class="btn btn-success type_radio" submit=false>radio</button>
                    <button type="button" class="btn btn-success type_checkbox" submit=false>checkbox</button>
                    <button type="button" class="btn btn-success type_selectbox" submit=false>selectbox</button>
                    <button type="button" class="btn btn-success type_textarea" submit=false>textarea</button>]</td>
                    <td class="sub">sub title <input type="text" class="sub_title" name=""  value=""></td>
                    <td class="form"><input type="text" class="fb-filter__text" name=""  value=""></td>
                </tbody>
            </table>
            </div>

            <div class="origin_temp" style="display:none">
                <div id="text">
                    <input type="text" class="fb-filter__text" name=""  value="">
                </div>
                <div id="radio">
                    <label for="">
                        <input type="radio" name="" id="" value="" >
                        <span></span>
                    </label>
                    <label for="">
                        <input type="radio" name="" id="" value=""  >
                        <span></span>
                    </label>
                </div>
                <div id="checkbox">
                     <label for="">
                        <input type="checkbox" name="" id="" value=""  >
                        <span></span>
                    </label>
                    <label for="">
                        <input type="checkbox" name="" id="" value=""  >
                        <span></span>
                    </label>
                </div>
                <div id="seletbox">
                    <select class="fb-filter__select" name="" item="">
                    <option value=""></option>
                    <option value="T">T</option>
                    </select>
                </div>
                <div id="textarea">
                    <textarea type="text" class="fb-filter__textarea"  name="" ></textarea>
                </div>
            </div>
            


        </div>

        <script>
            $(window).on("load", function(){
               $(".type_text").click( function (){
                    $(".form").html(""); //클리어 한번 하고 
                    $(".form").html($("#text").html());
               });
               $(".type_radio").click( function (){
                    $(".form").html(""); //클리어 한번 하고 
                    $(".form").html($("#radio").html());
               });
               $(".type_checkbox").click( function (){
                    $(".form").html(""); //클리어 한번 하고 
                    $(".form").html($("#checkbox").html());
               });
               $(".type_selectbox").click( function (){
                    $(".form").html(""); //클리어 한번 하고 
                    $(".form").html($("#seletbox").html());
               });
               $(".type_textarea").click( function (){
                    $(".form").html(""); //클리어 한번 하고 
                    $(".form").html($("#textarea").html());
               });
            });
        </script>

    </body>
</html>