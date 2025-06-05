<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    @include('layouts.partials-user.head')
  </head>

  <body style="background: linear-gradient(-45deg, #696CFF, #5E60CE, #3A0CA3, #4361EE, #00B4D8, #48CAE4, #F72585, #FFB703); background-size: 600% 600%; animation: gradientBG 16s ease-in-out infinite;">
  <style>
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      15% {background-position: 50% 100%;}
      30% {background-position: 100% 50%;}
      45% {background-position: 50% 0%;}
      60% {background-position: 0% 50%;}
      75% {background-position: 50% 100%;}
      90% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
  </style>
   
     @yield('content')

   @include('layouts.partials-user.scripts')

  </body>
</html>
