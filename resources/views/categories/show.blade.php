<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo config('app.name') ?></title>
    <link rel="stylesheet" href=<?= asset("css/bootstrap.min.css") ?>>
</head>

<body>
    <div class="container">
        <h1><?= $title ?? ''  ?></h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Parent ID</th>
                    <th scope="col">Created At</th>

                </tr>
            </thead>
            <tbody>


                <tr>
                    <td><?= $category->id  ?></td>
                    <td><a href="/categories/<?= $category->id ?>"><?= $category->name  ?></a></td>
                    <td><?= $category->slug  ?></td>
                    <td><?= $category->parent_id  ?></td>
                    <td><?= $category->created_at  ?></td>
                </tr>

            </tbody>
        </table>

    </div>






</body>

</html>
