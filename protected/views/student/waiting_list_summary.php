<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 16/07/14
 * Time: 04:48 م
 */
?>
<?php if (empty($summaryData)): ?>
    <p>لايوجد اي اسم في لوائح الانتظار</p>
<?php endif; ?>
<?php if (!empty($summaryData)): ?>
    <table class="table subtable">
        <thead>
        <tr>
            <th>اسم الدورة</th>
            <th>عدد الطلاب المنتظرين</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($summaryData as $data): ?>
            <tr>
                <td><?php echo $data['name'] ?></td>
                <td><?php echo $data['count'] ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

<?php endif; ?>