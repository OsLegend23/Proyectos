<div id="box_vacancy_center">
    <div id="box_vacancy">

        <h5 class="v-header2" id="vf_vacancyName"><?php echo $STR['VacancyName']; ?></h5>

        <div id="aboutWork" class="section">
            <span class="v-header" id="vf_Sector"><b> <?php echo $STR['WorkArea']; ?>:</b></span>
            <label class="v-field" id="vf_Activity"> <?php echo $STR['SameAsCompany']; ?></label>
            <br>

            <i class="mdi-action-wallet-travel prefix"></i><span class="v-header"><b> <?php echo $STR['VacancyType']; ?>
                    :</b></span>
            <label class="v-field" id="vf_VacancyType"> <?php echo $STR['VacancyType']; ?></label>
        </div>

        <div class="divider"></div>

        <div class="section v-field" id="vf_Requires">
            <div><b>PERFIL</b></div>
            <div class="v-field" id="vf_AgeOld"><?php echo $STR['AgeOld']; ?>:</div>
            <div class="v-field" id="vf_Gender"><?php echo $STR['Gender']; ?></div>
            <div class="v-field" id="vf_MaritalStatus"><?php echo $STR['MaritalStatus']; ?></div>
            <i class="boxshadowLow mdi-social-school"></i><span class="v-header"> <b><?php echo $STR['StudySpecs']; ?>
                    :</b></span>
            <label class="v-field " id="vf_StudySpecsList"></label>
            <!--            <div class="v-field" id="vf_StudySpecs"></div>-->
        </div>

        <div class="divider"></div>

        <div class="section" id="vf-requisitos">
            <div class="v-header  boxshadowLow" style="text-transform: uppercase;">
                <b><?php echo $STR['Requires']; ?></b></div>

            <span class="v-header"><b> <?php echo $STR['JobExperiencealone']; ?>: </b></span>
            <label class="v-field" id="vf_JobExperiencealone"> <?php echo $STR['JobExperiencealone']; ?></label>
            <br/>

            <span class="v-header boxshadowLow"><b><?php echo $STR['LanguageRequires']; ?>:</b></span>
            <label class="v-field" id="vf_LanguageRequires"></label>
        </div>

        <div class="divider"></div>

        <div class="section" id="vf-jobDescription">
            <div class="v-header boxshadowLow" style="text-transform: uppercase;"><b>Descripción del trabajo</b></div>
            <div class="v-field" id="vf_JobExperience">

            </div>
        </div>

        <div class="divider"></div>

        <div class="section" id="vf-workDetails">
            <div class="v-header boxshadowLow" style="text-transform: uppercase;">
                <b><?php echo $STR['WorkDetail']; ?></b></div>
            <ul class="vacancy_iframe">
                <div class="v-field" id="vf_WorkDetail" style="text-align: justify;"></div>
            </ul>
        </div>

        <div class="divider"></div>

        <div class="section" id="vf-information">
            <div class="v-header boxshadowLow" style="text-transform: uppercase;"><b><?php echo $STR['Info']; ?></b>
            </div>
            <ul class="vacancy_iframe">
                <div class="v-field" id="vf_CompanyInfo">
                </div>
            </ul>
        </div>


    </div>

</div>