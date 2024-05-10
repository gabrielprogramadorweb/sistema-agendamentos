<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            margin: 10px auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        p {
            line-height: 1.5;
            font-size: 16px;
        }
        .footer {
            font-size: 14px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
        .logo {
            display: block;
            margin: 20px auto;
            height: 60px;
        }
        .salutation {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div style="text-align: center;">
        <img src="https://uploaddeimagens.com.br/images/004/781/888/original/dental_.png" alt="Logo Estética Dental" style="height: 60px;">
    </div>
    <p>Olá, {{ $notifiable->name }}</p>
    <p>Seu agendamento para o dia {{ $schedule->chosen_date->format('d/m/Y H:i') }} foi criado com sucesso!</p>
    <p>Obrigado por utilizar nossa plataforma!</p>

    <p>Atenciosamente,<br>Estética Dental</p>
    <div class="footer">
        <p>© {{ date('Y') }} Estética Dental. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>
