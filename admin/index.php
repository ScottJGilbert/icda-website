<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>
    Congressional Debate | Illinois Congressional Debate Association
  </title>
  <link rel="icon" href="/public/images/favicon.png" />
</head>

<body>
  <form action="/api/new-user" method="post">
    <input name="name" type="text" />
    <label for="name">Name</label>
    <input name="username" type="text" />
    <label for="username">Username</label>
    <input name="password" type="password" />
    <label for="password">Password</label>

    <input type="radio" id="poster" name="access_level" value="Poster" />
    <label for="poster">Poster</label><br>
    <input type="radio" id="editor" name="access_level" value="Editor" />
    <label for="poster">Editor</label><br>
    <input type="radio" id="administrator" name="access_level" value="Administrator" />
    <label for="poster">Administrator</label><br>

    <input type="submit" value="Submit" />
  </form>
</body>

</html>