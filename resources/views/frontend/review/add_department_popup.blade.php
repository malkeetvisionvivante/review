<!-- add department -->
<div class="modal fade" id="request_new_department">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Request for New Department Addition</h4>
        <form method="post" id="add_department_form">
          <div class="form-group">
            <label>Department Name</label>
            <input type="text" placeholder="Department Name" class="form-control" name="name">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea placeholder="Description" class="form-control" name="description"></textarea>
          </div>
          <button type="submit" class="btn btn-success round-shape">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>