<style type="text/css">
/*
ul> ul
{
margin-left: 5px;
margin-top: 5px;
}
ul > ul > ul
{
margin-left: 8px;
}
ul > li
{
margin-top: 3px;
}*/
.border
{
border-bottom: 1px solid #ccc;
padding-bottom: 7px;
padding-top: 7px;
}
.right
{
border-right: 1px solid #ccc;
}
</style>
<div class="container">
    <div class="content-wrapper">
        <section id="content">
            <?php include 'ext-menu.php';?>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active">Pre-Submission (Peer) Review Proforma </li>
            </ol>
            <div class="clearfix">
            </div>
            <div class="panel panel-default flat article-container-inner">
                <div class="panel-body article-post">
                    <h3 class="panel-title">Pre-Submission (Peer) Review Proforma</h3>
                    <hr>
                    
                    <form>
                        <p>The purpose of this independent peer review is to identify areas for improvement which will ensure the project is scientifically valid
                        and increase its likelihood of acceptance for publication.</p>
                        <div class="form-group">
                            <label class=" control-label" for="inputEmail3">Project Title</label>
                            <input type="" name=""  id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class=" control-label" for="inputEmail3">Principal investigator</label>
                            <input type="" name=""  id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class=" control-label" for="inputEmail3">Version & date of Research protocol</label>
                            <input type="" name=""  id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class=" control-label" for="inputEmail3">Reviewer Name</label>
                            <input type="" name=""  id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class=" control-label" for="inputEmail3">Job Title</label>
                            <input type="" name=""  id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class=" control-label" for="inputEmail3">Institution</label>
                            <input type="" name=""  id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <p><input type="checkbox" name=""  id="">
                        I confirm that I am an independent reviewer undertaking this project and that I have no potential conflicts of interest in reviewing this research protocol.</p>
                        <hr>
                        <h3 class="panel-title">Questions and comments on the research protocol. </h3>
                        <h6>Please select between Yes & NO. A NO response will open a comment box where you can write your observations, required changes or suggestions.</h6>
                        <hr>
                    </div>
                    <div class="form-group">
                        <p>CRITERIA: Using the right column please indicate if each criteria has been addressed, in your opinion:
                            <?php $i=1;?>
                            <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No
                            <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                        </p>
                    </div>
                    <hr>
                    <div class="row border">
                        <div class="col-sm-10 right">
                            <b>TITLE: </b>Does it accurately reflects the purpose, design, results, and conclusions of the study?
                        </div>
                        <div class="col-sm-2 pull-down">
                            <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                        </div>
                        <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                    </div>
                    
                    <div class="row border">
                        <div class="col-sm-10 right">
                            <b>ABSTRACT: </b>Does it correctly and succinctly summarize the salient points of the study?
                        </div>
                        <div class="col-sm-2 pull-down">
                            <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                        </div>
                        <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                    </div>
                    
                    <div class="row border">
                        <div class="col-sm-10 right">
                        <b>INTRODUCTION: </b> Does it provide adequate background and rationale for performing the study?</div>
                        <div class="col-sm-2 pull-down">
                            
                            <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                        </div>
                        <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                    </div>
                    Does it place the study in the perspective of research conducted previously in the field?
                    <div class="row border">
                        <div class="col-sm-10 right">
                            <ul class="no-margin">
                                
                                <li>Why is study being done? Identify controversy?</li></div>
                                <div class="col-sm-2 pull-down">
                                    <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                                </ul>
                                <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                            </div>
                        </div>
                        
                        
                        <p>Is the literature discussed in the introduction adequate to introduce the purpose of the manuscript?</p>
                        <div class="row border">
                            <div class="col-sm-10 right">
                                <ul class="no-margin">
                                    <li>Is the functional, biological, and/or clinical significant of the topic established.</li>
                                </ul>
                            </div>
                            <div class="col-sm-2 pull-down">
                                <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                            </div>
                            <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                        </div>
                        <div class="row border">
                            <div class="col-sm-10 right">
                                <ul class="no-margin">
                                    <li>Strengths and limitations described such that a need for further study is established.</li>
                                </ul>
                            </div>
                            <div class="col-sm-2 pull-down">
                                <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                            </div>
                            <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                        </div>
                        <div class="row border">
                            <div class="col-sm-10 right">
                                <ul class="no-margin">
                                    <li>Is the literature discussed in the introduction directly related to the purpose of the manuscript and necessary to introduce the topic?</li>
                                </ul>
                            </div>
                            <div class="col-sm-2 pull-down">
                                <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                            </div>
                            <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                        </div><div class="row border">
                        <div class="col-sm-10 right">
                            <ul class="no-margin">
                                <li>Is it clear how the experimental approach to be used in the present study is likely to yield more definitive or unique insight than previous studies? </li>
                            </ul>
                        </div>
                        <div class="col-sm-2 pull-down">
                            <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                        </div>
                        <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                    </div><div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does it clearly state or imply the study hypothesis(es) or null hypothesis? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are the outcomes to be measured clearly described in the introduction or methods section?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is the literature discussed in the introduction directly related to the purpose of the manuscript and necessary to introduce the topic? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is it clear how the experimental approach to be used in the present study is likely to yield more definitive or unique insight than
                            previous studies?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does it clearly state or imply the study hypothesis(es) or null hypothesis?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are the outcomes to be measured clearly described in the introduction or methods section?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Does the introduction adequately introduce the purpose of the manuscript in a logically compelling way?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Is a clear and strong rationale provided for the importance of this manuscript?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                
                
                <div class="row border">
                    <h4><b>Study design and methodology</b></h4>
                    <p>Is the sample described in appropriate detail; procedures and data analysis described clearly and in sufficient detail?</p>
                </div>
                <!-- <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> IRB approved?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div> -->
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Type of study described? (RCT, Cohort, Case controlled, Case report, etc)</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                Is the experimental design of the study capable of answering the question implied by the study hypothesis?
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Do the methods address the purpose? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is there a control or comparison group in the treatment study?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are there factors not controlled between the groups: (list)</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is the study: Prospective or Retrospective</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                Is the methodology described in sufficient detail for others to repeat study
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is it reproducible?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>If not, do the authors provide a proper (peer reviewed) reference that would provide such details?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is there a rationale for the experimental design?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is the Study Population clearly identified</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Identified and appropriate to answer question?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Informed consent obtained?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li> Admission criteria clearly specified?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li> Inclusion / exclusion criteria </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Power analysis provided? </li>
                        </ul>
                    </div>
                    
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>  Where enough subjects studied to detect a difference? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Were subjects randomized?</li>
                        </ul>
                    </div>
                </div>
                
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>  What methods were used?  </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>If subjects were not randomized, were subjects and controls equivalent? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Was the randomization assignment concealed from both patients and healthcare staff until recruitment was complete
                            and irrevocable?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Will the subject population allow extensive or rather limited generalizability?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul><li><b>External validity:</b></li></ul>
                    </div>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Were the subjects asked to participate in the study representative of the entire population from which they were
                            recruited?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Were those subjects who were prepared to participate representative of the entire population from which they were
                            recruited?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Were the staff, places, and facilities where the patients were treated representative of the treatment the majority of
                            patients received </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul><li><b>Internal validity:</b></li></ul>
                    </div>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Was an attempt to blind study subjects to the intervention they have received? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Was there an attempt made to blind those measuring the main outcomes of the intervention?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Blinding</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Single‐blind (patient)</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Double‐blind (patient & investigator)</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>If any of the results of the study were biased on the data dredging, was this made clear? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Therapeutic intervention clearly defined? Treatments should be clearly described.</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Measurement Instrument or method clearly described?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Standard accepted measurement instrument or method? (ie. Universal?)</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Are metrics provided for standard instruments, procedures, or methods?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Non‐standard</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Unbiased?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Validated?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li>Reproducible?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are the details as to how the data were derived (calculated) adequately explained so that they can be confirmed by the
                            reviewer and reproduced by future investigators?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is it clear how the data will be interpreted to either support or refute the hypothesis? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Have the characteristics of patients lost to follow‐up been described. Follow‐up</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Adequate length?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li> Minimal_____ Average_____</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Is mechanism of follow‐up described?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Loss to follow‐up reported? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                
                <h4><b>Soundness of the Results</b></h4>
                
                
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are the data reported in a clear, concise, and well‐organized manner?</li>
                        </ul>
                    </div>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is there excessive variability in one or more of the measurements for a particular condition compared with others? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Are the main findings of the study clearly described? Simple outcome data should be reported for all major findings so that
                            the reader can check the major analyses and conclusions.</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> All results must be proposed in the methods.</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Are they relevant to the study or research problem?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Are data presented that was not described in the methods? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>  Reported in sufficient detail?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Statistical results tell statistical significance? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Actual results tell clinical significance?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>  Was compliance with the intervention reliable?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Do the tables and figures clarify or confuse?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Are all the figures and tables needed?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Are the tables and figures properly labeled with titles and the correct units?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is the scaling of the figures appropriate and unbiased?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Was randomization successful? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Statistics: </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Appropriate test(s) chosen?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Appropriate p‐value chosen (a priori)?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li> Have the actual probability values been reported rather than &lt; 0.05 for the main outcomes except were the probability
                            value is less than 0.001.</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-8 col-md-offset-2 right">
                        <ul class="no-margin" style="list-style-type:circle">
                            <li> Have adjustments been made for multiple comparisons?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does the study provide estimates of the random variability in the data for the main outcomes? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Does the analysis adjust for different lengths of follow‐up of patients, or in case‐controlled studies, is the time period between the intervention and outcome the same for cases and controls?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> If findings are negative, was a sufficiently large population studied? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Remember: failure to show a difference is NOT the same as showing that there is no difference – may be a lack of power.</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Have all the important adverse events that may be a consequence of the intervention been reported? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are findings clinically significant? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>How do the group differences or responses shown compare with the measurement variability?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <h4><b>Discussion and Conclusion</b></h4>
                <h5><b>Discussion</b></h5>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are the major new findings of the study clearly described and properly emphasized?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is the significance of the present results described?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Is it clear how the findings extend previous knowledge in a meaningful way?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does it point out weaknesses/limitations of the study? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li><b>Biases:</b></li>
                        </ul>
                    </div>
                    
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Selection</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Performance</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Detection (measurement) </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Transfer (loss of follow‐up)</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does it point out the strengths of the study?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does it place the study in perspective with existing literature?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Discuss similarities and differences</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Are important experimental observations from previous reports described in the context of the present results?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li><b>Excessive speculation?</b></li>
                        </ul>
                    </div>
                    
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Does it distinguish author opinion from the conclusions</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Do the authors support their statements with appropriate references?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Do the authors discuss their data in a manner that provides insight beyond that presented in previous sections?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is there any other way to interpret and/or explain the data other than that suggested by the authors?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <h5><b>Conclusion</b></h5>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Was hypothesis proved?</li>
                        </ul>
                    </div>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>  Is it based on the data described in the results?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Key conclusions adequately supported by the experimental data?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does it point out the clinical significance of the conclusions?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Does it suggest the possible direction of future investigation?</li>
                        </ul>
                    </div>
                    
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Do authors make suggestions as to how the results of their study need to be extended in the future to learn more about the
                            issue in question?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Are conclusions justified by the results of the study?</li>
                        </ul>
                    </div>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Does it stray beyond the boundaries of the study?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <h4><b>Organization and Style</b></h4>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Is the manuscript concise?</li>
                        </ul>
                    </div>
                </div>
                
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li> Is the material presented, without excessive jargon? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Are all the graphs or charts needed? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Was the paper well written, properly organized, and easy to follow?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Was proper grammar, spelling, and punctuation used throughout?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Should manuscript be shortened? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Should manuscript be more comprehensive?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <h4><b>References</b></h4>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are the major references included?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Are all references cited completely and in the desired format of the journal</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> References chosen directly relate to the study?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Avoids secondhand or abstract reference sources?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Are all references cited correctly in text, e.g superscripted following punctuation.</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <h4><b>Overall Significance and Suitability</b></h4>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Is the manuscript sophisticated enough for the intended professional audience?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Was the information presented in an open‐minded and objective manner? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Is the experimental question significant?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li> Is a clear and testable hypothesis presented?</li>
                        </ul>
                    </div>
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>Overall method is valid?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Results are properly presented and believable?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Conclusions are reasonable on the basis of the results obtained?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does manuscript contain new findings or ideas?</li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
                <div class="row border">
                    <div class="col-sm-10 right">
                        <ul class="no-margin">
                            <li>Does the manuscript provide a unique contribution?</li>
                        </ul>
                    </div>
                    
                </div>
                <div class="row border">
                    <div class="col-sm-9 col-md-offset-1 right">
                        <ul class="no-margin" style="list-style-type:square">
                            <li>If not, does it present old material better? </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 pull-down">
                        <input type="radio" name="question_<?php echo $i;?>" id="input" onchange="get_ans('yes',<?=$i?>)" value="Yes" checked="checked">Yes&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="question_<?php echo $i;?>" id="input" value="No" onchange="get_ans('no',<?=$i?>)" >No

                    </div>
                    <textarea style="display:none;margin-top:10px;" name="comment_<?php echo $i;$i++?>" class="form-control" placeholder="Insert Comment"></textarea>
                </div>
            </div>
        </div>
    </form>
    
</section>

<script type="text/javascript">
    function get_ans (ans,id) 
    {
        if(ans == 'yes')
        {
            $("textarea[name='comment_"+id+"']").slideUp();
        }
        if(ans == 'no')
        {
            $("textarea[name='comment_"+id+"']").slideDown();
        }
    }
</script>