<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="dashboard">
    <Dashboardcomponent></Dashboardcomponent>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script>
    const app = createApp({});
    app.component('dashboard-component', DashboardComponent);
    app.mount('#dashboard');
</script>
</body>
</html>
