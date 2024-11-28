
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Email Template | CM</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic,600italic' rel='stylesheet' type='text/css'>


    <style >
        .email-table {
            margin: 0 auto;
            font-family: 'Open Sans', sans-serif;

        }

        .email-table table thead tr th{
            background-color: transparent;
            color: #000;
            text-align: left;
            padding: 0px;
        }
        .email-table table thead tr th{
            padding: 5px 0px;
            font-size: 14px;
        }

        .email-table tfoot > tr > td  {

        }
        .borderd-table{
            border: 1px solid #e5e5e5 !important;
        }
        .borderd-table thead > tr > th {
            border-top: 0;
            border-right: 1px solid #e5e5e5;
            border-bottom: 2px solid #e5e5e5;
            border-left: 0;
            padding: 7px 5px !important;
            font-size: 12px !important;
        }
        .borderd-table tbody > tr > td {
            border-right: 1px solid #e5e5e5;
            border-bottom: 1px solid #e5e5e5;
            padding: 5px !important;
            font-size: 12px;
        }
        .borderd-table tbody > tr:last-child > td {
            border-bottom:0px;
        }
        .borderd-table tbody > tr > td:last-child, .borderd-table thead > tr > th:last-child  {
            border-right: 0;
        }

    </style>

</head>
<body>

<table class="email-table" width="600" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th style="background-color: #34B0E6;padding:20px;font-weight: 600;text-transform: uppercase;color: #ffffff;"><?php $companyname = BaseController::getCompanyName();
                echo $companyname;
              ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0">

                <tr>
                    <td style=" padding: 20px 20px 0px;background-color: #FAFAFA;">
                        <table cellpadding="0" cellspacing="0" width="100%" style="margin: 20px 0;">
                            <tr>
                                <td>Dear <?php echo $to.","."<br>"?></td>
                            </tr>

                            <tr>
                                <td>Following tasks is hold</td>
                            </tr>
                            <tr>
                                <td><?php echo "<br>"; ?></td>
                            </tr>

                            <tr>
                                <td><strong>Task description :</strong></td>
                            </tr>
                            <tr>
                                <td><?php echo "<br>"; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:10px">
                                    <?php  
                                            echo $user."<br><br>";
                                           
                                    ?>
                                </td>
                            </tr>
                              <tr>
                                <td><strong>Comment :</strong></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:10px">
                                    <?php  
                                            echo $comment."<br><br>";
                                           
                                    ?>
                                </td>
                                
                            </tr>

                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>

    </tbody>
    <tfoot>
    <tr>
        <td style="font-size:12px;text-align: center;
        background-color: #34B0E6;
        padding: 20px;
        color: #ffffff;">Powered By Probity Technologies © 2016</td>
    </tr>
    </tfoot>
</table>

</body>
</html>


