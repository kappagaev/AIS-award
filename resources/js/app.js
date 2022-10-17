import './bootstrap';
import '../sass/app.scss';
import 'jquery';
$(document).ready(function() {
    $('.selectpicker').selectpicker();
    $('.bs-searchbox').children('.form-control').on('change', function() {
        console.log($(this).parent().parent().parent().children('.selectpicker')[0].options);
        $('#faculty').append('<option value="fsdfsdf">fsdfs</option>');
        $(this).parent().parent().parent().children('.selectpicker')[0].options.add( new Option('test',"12"));
    });
 });