## Using the layout

In order to use the layout, your view(s) should extend from the provided base layout

```
{% extends '@SbSAdminLTE/Layout/base.html.twig' %}
```

For example you can do it in /app/Resources/views/base.html.twig and all your views will be use the AdminLTE theme.

### Layout Blocks

#### title
  Located in tag `<head>`. Using for title of page.

#### corestyles
  Located in tag `<head>`. Using for main theme CSS, on prod environment all files will be merged in one `admin-lte-bundle.min.css`.
  Please don't forget to use `{{ parent() }}` if you want adding your stylesheets in theme. For example:
```twig
{% block corestyles %}
    {{ parent() }}
    {% stylesheets output="css/components.min.css" filter="cssrewrite"
    "components/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css" %}
    <link rel="stylesheet" href="{{ asset_url }}"/>
    {% endstylesheets %}
{% endblock %}
```

#### stylesheets
  Located in tag `<head>`. Use standard twig block stylesheets to include CSS that is used on single page.

#### corejs
  Located in tag `<head>`. Using for main theme JS, on prod environment all files will be merged in one `admin-lte-bundle.min.js`.
  Please don't forget to use `{{ parent() }}` if you want adding your javascripts in theme. For example:
```twig
{% block corejs %}
    {{ parent() }}
    {% javascripts output="js/components.min.js"
    "components/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js" %}
    <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}
```

#### javascripts_head
  Located in tag `<head>`. Using if we need add some javascript in head of page. You can use it to integrate modernizr.js or etc.

#### admin_lte_header
  Located in `<div class="wrapper">`. Contains admin_lte_navbar and admin_lte_logo blocks. It is not recommended to redefine.

#### admin_lte_logo
  Used for theme logo. You can redefine it for your project. For example:
```twig
{% block admin_lte_logo %}
    <a href="{{ path('homepage') }}" class="logo">
        <span class="logo-mini"><i class="fa fa-lg fa-home"></i></span>
        <span class="logo-lg">My Application</span>
    </a>
{% endblock %}
```

#### admin_lte_navbar
  This block used for navigation custom menu. It is not recommended to redefine.

#### admin_lte_sidebar
  Located in tag `<aside>`. This block used for left side column. It is not recommended to redefine.

#### content
 Located in `<div class="content-wrapper">`. Contains header_content, admin_lte_breadcrumb and page_content blocks.

#### header_content
  Contain "Page Title" and "Description of Page". Recommend use AdminLTE macros for define it.
  For example:
```twig
{% import "@SbSAdminLTE/Layout/main_macros.html.twig" as macros %}
...
{% block header_content %}
    {{ macros.page_header("Homepage", "Short description of homepage.") }}
{% endblock %}
...
```

#### admin_lte_breadcrumb
  Should contain breadcrumbs.

#### page_content
  The main page content area.

#### admin_lte_footer
  Located in tag `<body>`. This is footer content area.

#### javascripts
  Located before tag `<body>` close. Use standard twig block javascripts to include JS that is used on single page
