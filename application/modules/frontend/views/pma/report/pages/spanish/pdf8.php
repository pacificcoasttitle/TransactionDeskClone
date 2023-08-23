<page class="pdf5">
    <div class="container">
        <?php
            $plat_file = base_url('assets/pma/report/img/map1.png');
            if(isset($report_111) && !empty($report_111)) {
                $plat_file = 'data:image/png;base64,'.$report_111->PlatMap->Content;
                
            }
        ?>  

        <img src="<?php echo base_url('assets/pma/report/img/13_spanish.jpg');?>" alt="assessor">
        <div class="main_content">                
            <img src="img/map1.png" alt="">
            <a href="#" class="mt-80 d-block"><img src="<?php echo base_url('assets/pma/report/img/pacific_logo.png');?>" alt="pacific_logo" class="footer_logo"></a>
            <p class="copyright">Datos Considerados Fiables, Pero Núm.Garantizados. Pacific Coast Title Company. Todos los Derechos Reservados.</p>
        </div>
    </div>
</page>