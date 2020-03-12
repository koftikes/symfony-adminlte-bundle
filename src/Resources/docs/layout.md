## Using the layout

In order to use the layout, your view(s) should extend from the provided base layout

```
{% extends '@SbSAdminLTE/Layout/base.html.twig' %}
```

For example you can do it in /app/Resources/views/base.html.twig and all your views will be use the AdminLTE theme.

### Layout Blocks

#### title
  Located in tag `<head>`. Using for title of page.

#### favicon
  Located in tag `<head>`. Using for favicon of page.
  
#### corestyles
  Located in tag `<head>`. Please don't forget to use `{{ parent() }}` if you want adding your stylesheets in theme. For example:
```twig
{% block corestyles %}
    {{ parent() }}
    <link rel="stylesheet" href="{{ asset_url }}"/>
{% endblock %}
```

#### stylesheets
  Located in tag `<head>`. Use standard twig block stylesheets to include CSS that is used on single page.

#### corejs
  Located in tag `<head>`. Please don't forget to use `{{ parent() }}` if you want adding your javascripts in theme. For example:
```twig
{% block corejs %}
    {{ parent() }}
    <script type="text/javascript" src="{{ asset_url }}"></script>
{% endblock %}
```

#### javascripts_head
  Located in tag `<head>`. Using if we need add some javascript in head of page. You can use it to integrate modernizr.js or etc.

#### fonts
  Located in tag `<head>`. Using if we need add some font in head of page. Please don't forget to use `{{ parent() }}`. For example:
```twig
{% block fonts %}
    {{ parent() }}
    <link rel="stylesheet" href="{{ url }}">
{% endblock %}
```

#### admin_lte_navbar
  Located in `<div class="wrapper">`. Contains `sidebar_toggle_button`, `navbar_menu`, `navbar_notifications`, `navbar_tasks` and `navbar_user_account`. 
  It is not recommended to redefine.

#### admin_lte_logo
  Used for theme logo. You can redefine it for your project. For example:
```twig
{% block admin_lte_logo %}
    <a href="{{ path('some_path') }}" class="brand-link">
        <img src="{{ asset('img/my_logo.png') }}" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">My Application</span>
    </a>
{% endblock %}
```

#### admin_lte_sidebar
  Located in tag `<aside>`. This block used for left side column. It is not recommended to redefine.

#### header_content
  Located in `<div class="content-wrapper">`. Contains `page_header` and `page_breadcrumb`. It is not recommended to redefine.

#### page_header
  Contain "Page Title", "Description of Page". Recommend use AdminLTE macros for define it.
  For example:
```twig
{% import "@SbSAdminLTE/Layout/main_macros.html.twig" as macros %}
...
{% block page_header %}
    {{ macros.page_header("My page", "Description of my page.") }}
{% endblock %}
...
```

#### page_breadcrumb
  Should contain breadcrumbs.

#### page_content
  Located in `<section class="content">`. The main page content area.

#### admin_lte_footer
  Located in `<div class="wrapper">`. This is footer content area.

#### javascripts
  Located before tag `<body>` close. Use standard twig block javascripts to include JS that is used on single page
