<section class="content-header">
    <div class="row">
        <div class="col-md-offset-2 col-md-1 text-right">  
            <h2><i class="fa fa-reply btn" onclick="window.history.back()"></i> </h2>
        </div>
        <div class=" col-md-9" style="padding-left:0">  
            <h2><?=$title?></h2>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">        
            <div class="row">
                <div class="col-md-12" style="">   
                    <form id="newservice" class="form-horizontal" method="post" action="<?=base_url('index.php/services/add')?>">    
                    <?=$form?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>