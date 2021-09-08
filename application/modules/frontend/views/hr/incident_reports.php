<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <div class="typography-section__inner">
                        <h2 class="ui-title-block ui-title-block_light">Incident Report,</h2>
                        <div class="ui-decor-1a bg-accent"></div>
                        <h3 class="ui-title-block_light">Use the form below to file a new incident.</h3>
                    </div>
                    <div class="typography-sectiona">
                        <div class="col-md-12">
                            <div class="smart-wrap">
                                <div class="smart-forms smart-container wrap-0">
                                    <div class="form-body smart-steps stp-three">
                                        <form method="post" action="php/smartprocess.php" id="smart-form">
                                            <h2>Employee Details</h2>
                                            <fieldset>
                                                <h2> Employee Details</h2>
                                                <p> Please enter the details and incident date of the employee. <br><br></p>
                                                <div class="frm-row">
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="firstname" id="firstname" class="gui-input" placeholder="First name">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div>
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="lastname" id="lastname" class="gui-input" placeholder="Last name">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="frm-row">
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="email" name="emailaddress" id="emailaddress" class="gui-input" placeholder="Email address">
                                                            <span class="field-icon"><i class="fa fa-envelope"></i></span>
                                                        </label>
                                                    </div>

                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="tel" name="telephone" id="telephone" class="gui-input" placeholder="Employee number">
                                                            <span class="field-icon"><i class="fa fa-phone-square"></i></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="frm-row">
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="position" id="position" class="gui-input" placeholder="Employee Position">
                                                            <span class="field-icon"><i class="fa fa-user"></i></span>
                                                        </label>
                                                    </div>
                                                    <div class="section colm colm6">
                                                        <label class="field prepend-icon">
                                                            <input type="text" name="end_date" id="end_date" class="gui-input" placeholder="Incident Date" readonly>
                                                            <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <h2>Incident Details</h2>
                                            <fieldset>
                                                <h2> Incident Details</h2>
                                                <p> Please enter the details of the incident<br><br></p>
                                                <div class="frm-row">
                                                    <div class="section colm colm12">
                                                        <label class="field select">
                                                            <select id="services" name="Reason:">
                                                                <option value="">Late</option>
                                                                <option value="">Missing Work</option>
                                                                <option value="">Peer Interaction</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                            <i class="arrow double"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="section">
                                                    <label class="field prepend-icon">
                                                        <textarea class="gui-textarea" id="projectdetails" name="projectdetails" placeholder="Please enter the specific details of the incident"></textarea>
                                                        <span class="field-icon"><i class="fa fa-comments"></i></span>
                                                        <span class="input-hint">
                                                            <strong>Event Details:</strong> add more specific details
                                                        </span>
                                                    </label>
                                                </div>
                                            </fieldset>
                                            <h2>Actions Taken</h2>
                                            <fieldset>
                                                <h2> Actions Taken</h2>
                                                <p class="nospace"> Please enter the actions taken<br><br></p>
                                                <div class="frm-row">
                                                    <div class="option-group field">
                                                        <div class="section colm colm4">
                                                            <label class="option block">
                                                                <input type="checkbox" name="extras[]" value="1st">
                                                                <span class="checkbox"></span> First
                                                            </label>
                                                        </div>

                                                        <div class="section colm colm4">
                                                            <label class="option block">
                                                                <input type="checkbox" name="extras[]" value="2nd">
                                                                <span class="checkbox"></span> Second
                                                            </label>
                                                        </div>

                                                        <div class="section colm colm4">
                                                            <label class="option block">
                                                                <input type="checkbox" name="extras[]" value="3rd">
                                                                <span class="checkbox"></span> Third
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h2>Frequency of Incident:</h2>
                                                <p class="nospace"> Please enter the amount of times this incident has taken place:<br><br></p>

                                                <div class="frm-row">
                                                    <div class="option-group field">
                                                        <div class="section colm colm4">
                                                            <label class="option block">
                                                                <input type="checkbox" name="extras[]" value="Verbal Warning">
                                                                <span class="checkbox"></span> Warned Employee
                                                            </label>
                                                        </div>

                                                        <div class="section colm colm4">
                                                            <label class="option block">
                                                                <input type="checkbox" name="extras[]" value="Sent Home">
                                                                <span class="checkbox"></span> Sent Home
                                                            </label>
                                                        </div>

                                                        <div class="section colm colm4">
                                                            <label class="option block">
                                                                <input type="checkbox" name="extras[]" value="No Action">
                                                                <span class="checkbox"></span> No Action
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="result spacer-b10"></div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <div class="typography-section__inner">
                        <h2 class="ui-title-block ui-title-block_light">Incident Report History,</h2>
                        <div class="ui-decor-1a bg-accent"></div>
                        <h3 class="ui-title-block_light">Below is a detail of all your requests.</h3>
                    </div>
                    <div class="typography-sectiona">
                        <div class="col-md-12">
                            <div class="table-container">
                                <table class="table table-type-3 typography-last-elem">
                                    <thead>
                                        <tr>
                                            <th>Employee #</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Reason</th>
                                            <th>Occurence</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="typography-sectionab">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>