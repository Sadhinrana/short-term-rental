<div class="row">
    <div class="col-md-6" style="overflow: hidden">
        <img class="responsive-image" src="{{ asset($imageDescription->image) }}">
    </div>
    <div class="col-md-6">
        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#pills-object" role="tab" class="nav-link active" id="pills-object-tab" data-toggle="pill"
                   aria-controls="pills-labels" aria-selected="true">Object</a>
            </li>
            <li class="nav-item">
                <a href="#pills-labels" role="tab" class="nav-link" id="pills-labels-tab" data-toggle="pill"
                   aria-controls="pills-web" aria-selected="true">Labels</a>
            </li>
            <li class="nav-item">
                <a href="#pills-text" role="tab" class="nav-link" id="pills-text-tab" data-toggle="pill"
                   aria-controls="pills-properties" aria-selected="true">Text</a>
            </li>
        </ul>
        <hr>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" style="" id="pills-object" role="tabpanel" aria-labelledby="pills-object-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $object = json_decode($imageDescription->image_object);
                                if($object){
                                ?>
                                <ol style="height: 330px; overflow: auto">
                                    <?php
                                    foreach ($object->localizedObjectAnnotations as $row){
                                    ?>
                                    <li><h6> <?php echo ucfirst($row->name); ?></h6> </h6> Confidence: <strong><?php echo number_format($row->score*100, 2) ?></strong><br><br></li>
                                    <?php }?>
                                </ol>
                                <?php }else{?>
                                    <h6 class="text-center"><strong>No Object Found !</strong></h6>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show"  id="pills-labels" role="tabpanel" aria-labelledby="pills-labels-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $lables = json_decode($imageDescription->image_labels);
                                if($lables){
                                ?>
                                <ol style="height: 330px; overflow: auto">
                                    <?php
                                    foreach ($lables->labelAnnotations as $row){
                                    ?>
                                    <li><h6> <?php echo ucfirst($row->description); ?></h6> </h6> Confidence: <strong><?php echo number_format($row->score*100, 2) ?></strong><br><br></li>
                                    <?php }?>
                                </ol>
                                <?php }else{?>
                                    <h6 class="text-center"><strong>No Labels Found !</strong></h6>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="pills-text" role="tabpanel" aria-labelledby="pills-text-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $text = json_decode($imageDescription->image_text);
                                if($text){
                                ?>
                                <ol style="height: 330px; overflow: auto">
                                    <?php
                                    foreach ($text->textAnnotations as $row){
                                    ?>
                                    <li><h6> <?php echo ucfirst($row->description); ?></h6> </li>
                                    <?php }?>
                                </ol>
                                <?php }else{?>
                                    <h6 class="text-center"><strong>No Text Found !</strong></h6>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
