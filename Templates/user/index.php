
<div class="navbar">
    <a class="btn btn-primary" href="/register">Create user</a>
</div>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>CITY</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ((array)$users as $user): ?>
        <tr>
            <td><?=$user->id?></td>
            <td><?=$user->name?></td>
            <td><?=$user->email?></td>
            <td><?=$user->territory()->ter_address?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?=$links?>
