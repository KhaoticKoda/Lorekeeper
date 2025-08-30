<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include Bootstrap and Bootstrap Icons if not already present -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

<!-- The Main Hub -->
<div style="padding: 20px;" id="fm"></div>

<!-- Include the file manager script -->
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

<script>
    new Vue({
        el: '#fm',
        components: { FileManager },
    });
</script>