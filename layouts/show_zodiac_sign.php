<?php

include('header.php');
$data_of_birth = DateTime::createFromFormat('Y-m-d', $_POST['data_nascimento']);

if(!$data_of_birth){
    echo("<p>Data inálida</p><a href='index.php'>");
}

$signs = simplexml_load_file('sings.xml');

function sing_verification($data, $start, $end){
        $year = $data->format('Y');
        $data_start = DateTime::createFromFormat('d/m/Y', "$start/$year");
        $data_end = DateTime::createFromFormat('d/m/Y', "$end/$year");

    if($data_start > $data_end) {
        $data->format('m') =='01' ? $data_start->modify('-1 year') : $data_end->modify('+1year');
    }
    
    return($data >= $data_start && $data <= $data_end);
}

$sign_found = null;
foreach($signs as $sign){
    if(sing_verification($data_of_birth, $sign->startDate, $sign->endDate)){
        $sign_found = $sign;
        break;
    }
}

?>
<body>
    <div class="container-fluid main-container mt-4 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="content-wrapper text-center p-5" style="background-color: white; border-radius: 15px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); max-width: 500px;">
            <?php if ($sign_found): ?>
                <h1 class="mb-4" style="color:#A020F0">Seu signo é: <?= $sign_found->signName ?></h1>
                <p class="text-muted mb-5"><?= $sign_found->description ?></p>
            <?php else: ?>
                <p class="text-danger mb-5">Data inválida! Não foi possível encontrar um signo correspondente.</p>
            <?php endif; ?>
            <a href='index.php' class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</body>