<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add Category</title>
    </head>
    <body>
       <h1>Add Category</h1>
       <div class="col-lg-6">
        <form method="post" action="index.php?content_page=AddCategoryAction">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="category_name" class="form-control" placeholder="Category Name">
                </div>                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="category_description" class="form-control" rows="5" placeholder="Write Description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </body>
</html>