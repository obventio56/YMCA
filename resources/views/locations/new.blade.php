<form action="/location/create" method="post">
  {{ csrf_field() }}
  <input name="title" type="text" placeholder="Title" />
  <textarea name="notes"placeholder="Title" ></textarea>
  <input type="Submit"/>
</form>