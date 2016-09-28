<table border="1">
    <?php foreach ($response as $item) :?>
        <tr>
            <td><?php echo $item->result['id']?></td>
            <td><?php echo $item->result['name']?></td>
            <td><?php echo $item->result['age']?></td>
        </tr>
    <?php endforeach;?>
</table>
<?php