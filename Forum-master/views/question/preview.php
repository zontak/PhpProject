<div>
<h1><?= $this->post['title'] ?></h1>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Username:<strong><?= $this->post['author'] ?></strong>
            <div class="pull-right"><?= $this->post['date'] ?></div>
        </div>
        <div class="panel-body">
            <p>
                <?= $this->post['text'] ?>
            </p>
        </div>

    </div>

    <div><h3>ANSWERS</h3></div>
        <div class="panel panel-primary">
            <div class="panel-heading">Username: <strong> #</strong>
                <div class="pull-right"> </div></div>
            <div class="panel-body">
                <p>
                    answer
                </p>
            </div>
        </div>

</div>

<form class="form-horizontal col-lg-6 col-lg-offset-3" >
    <fieldset>
        <legend>Send Answer</legend>

        <div class="form-group">
            <label for="textArea" class="col-lg-2 control-label">Textarea</label>
            <div class="col-lg-10">
                <textarea class="form-control" rows="3" id="textArea" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
                <input class="form-control" id="inputEmail" placeholder="Email" type="text">
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </fieldset>
</form>
