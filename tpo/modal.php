

<div class="modal" id="add-drive-modal" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">     
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Drive Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
<!----------------------------------------------Form-------------------------------------------->
                <form id="add-drive-form">
                    <div class="row mb-3">
                        <label for="company-name-inp" class="col-sm-4 col-form-label">Company Name</label>
                        <div class="col-sm-8">
                        <input required type="text" class="form-control" id="company-name-inp">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="designation" class="col-sm-4 col-form-label">Designation</label>
                        <div class="col-sm-8">
                        <input type="text" required class="form-control" id="designation">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                        <textarea id="description" required class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-4 pt-0">Criteria</legend>
                        <div class="col-sm-8">
                            <div class="criteria">                           
                                <label class="form-check-label" for="ssc_per">
                                SSC %
                                </label>
                                <input type="text" id="ssc_per" class="form-control" >
                            </div>
                            <div class="criteria">
                                <label class="form-check-label" for="hsc_dip_per">
                                HSC/Diploma %
                                </label>
                                <input type="text" id="hsc_dip_per" class="form-control" >
                            </div>
                            <div class="criteria">
                                <label class="form-check-label" for="cca">
                                Current Course Agg. %
                                </label>
                            <input type="text" id="cca" class="form-control" >
                            </div>
                            <div class="criteria">
                                <label class="form-check-label" for="mlk">
                                Max Live KT
                                </label>
                                <input type="text" id="mlk" class="form-control" >
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="strict-check">
                                <label class="form-check-label" for="strict-check">
                                Strict Checking
                                </label>
                               
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="no-criteria">
                                <label class="form-check-label" for="no-criteria">
                                No Criteria
                                </label>                              
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-4 pt-0">Package</legend>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="package" id="packagef" value="f" >
                                <label class="form-check-label" for="packagef">
                                Fixed
                                </label>
                                <input type="text" id="fixed-inp" class="form-control" >
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="package" type="radio" id="packager" value="r">
                                <label class="form-check-label" for="packager">
                                Range
                                </label>
                                <input type="text" id="range-inp" placeholder="e.g. 4-6" class="form-control" >
                            </div>
                        </div>
                    </fieldset>
                    <div class="row mb-3">
                        <label for="job-location" class="col-sm-4 col-form-label">Job Location</label>
                        <div class="col-sm-8">
                        <input id="job-location" required class="form-control" ></input>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="drive-starts" class="col-sm-4 col-form-label">Drive Starts</label>
                        <div class="col-sm-8">
                        <input type="text"  class="form-control" id="drive-starts"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="app-ends" class="col-sm-4 col-form-label">Application Ends</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="app-ends"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="elig-branch" class="col-sm-4 col-form-label">Eligible Branches</label>
                        <div class="col-sm-8 d-flex">
                            <select id="elig-branch" required class="form-select" aria-label="Default select example">
                                <option selected value="0">Select Branch</option>
                                <option value="1">Computer Science</option>
                                <option value="4">Civil</option>
                                <option value="3">Mechanical</option>
                                <option value="2">Electrical</option>
                                <option value="5">Electronics and Telecommunication</option>
                            </select>
                            <i id="add-elig-branch-ico"  class="fas fa-plus-circle align-self-center fa-2x"></i>
                        </div>                      
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8" id="selected-branches">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="sheet-link" class="col-sm-4 col-form-label">Sheet Link</label>
                        <div class="col-sm-8">
                        <input id="sheet-link" required class="form-control" ></input>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn"  class="btn btn-primary">Submit</button>
                </form>
<!----------------------------------------------Form-------------------------------------------->
            </div>     
        </div>
    </div>
</div>