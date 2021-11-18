<?php 
    require_once("../config.php");
?>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    h2{
        background-color: #333;
        color: white;
        padding: 8px;
    }
    .box{
        width: 900px;
        margin: auto;
    }

    table{
        width: 900px;
        margin-top: 15px;
        border-collapse: collapse;
    }

    table td{
        font-size: 18px;
        padding: 8px;
        border: 1px solid #ccc;
    }

    table tr:nth-of-type(1) td{
        font-weight: bold;
    }
</style>
<?php 
    $nome = (isset($_GET['pagamento']) && $_GET['pagamento'] == 'concluidos') ? 'Concluídos' : "Pendentes";
?>
<div class="box">
    <h2>Pagamentos <?php echo $nome;?></h2>
    <div class="table-wraper">
        <table>
            <tr>
                <td>Nome do Pagamento</td>
                <td>Cliente</td>
                <td>Valor</td>
                <td>Vencimento</td>
            </tr>
            <?php 
                $status = $nome == "Concluídos" ? 1 : 0;
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = ? ORDER BY vencimento ASC");
                $sql->execute(array($status));
                $pagos = $sql->fetchAll();
                foreach ($pagos as $key => $value) {
                    $cliente = MySql::conectar()->prepare("SELECT nome FROM `tb_admin.clientes` WHERE id = ?");
                    $cliente->execute(array($value['cliente_id']));
                    $cliente = $cliente->fetch();
            ?>
            <tr <?php echo $style;?>>
                <td><?php echo $value['nome'];?></td>
                <td><?php echo $cliente['nome'];?></td>
                <td><?php echo $value['valor'];?></td>
                <td><?php echo date("d/m/Y", strtotime($value['vencimento']));?></td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>
