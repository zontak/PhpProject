<form class="form-horizontal" method="POST">
  <fieldset>
    <legend>Legend</legend>
    <div class="form-group">
      <label for="inputTitle" class="col-lg-2 control-label">title</label>
      <div class="col-lg-3">
        <input type="text" class="form-control" id="inputTitle" placeholder="Title" name="title" required>
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Textarea</label>
      <div class="col-lg-8">
        <textarea class="form-control" rows="3" id="textArea" name="text" required></textarea>
        <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
      </div>
    </div>
    <div class="form-group">
      <label for="inputTags" class="col-lg-2 control-label">Tags</label>
      <div class="col-lg-3">
        <input type="text" class="form-control" id="inputTags" placeholder="Tags" name="tags" required>
      </div>
    </div>
    <div class="form-group">
      <label for="select" class="col-lg-2 control-label">Categories</label>
      <div class="col-lg-3">
        <select class="form-control" id="select" name="category" required>
          <?php
          foreach($GLOBALS['categories'] as $key => $val):
          ?>
        <option value="<?php echo $key ?>"><?php echo $val ?></option>
        <?php
        endforeach;
        ?>
        </select>
        <br/>
        </div
        </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary" name="Submit">Submit</button>
      </div>
    </div>
  </fieldset>
</form>