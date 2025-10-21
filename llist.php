<?php
// 페이지네이션
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$page_block = 5;

// 총 레코드
$total_count = $DB->single("SELECT count(*) FROM {$target_table}");
$paging = $Page->paging($total_count, $page, $limit, $page_block, dirname($_SERVER['PHP_SELF']) . '?table=free&page=');

// 페이지 관련 계산
$offset = ($page - 1) * $limit; // limit 시작 지점

// 게시판 데이터 불러오기
$sql = "SELECT * FROM {$target_table} WHERE (1) ORDER BY idx DESC LIMIT {$offset}, {$limit}";
$get_data = $DB->query($sql);

$virtual_number = $total_count - $offset;

echo "<pre>";
print_r($sql);
echo "</pre>";

?>
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">📋 <?= $bo_table ?> 게시판 목록</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-light">
            <tr>
                <th style="width: 80px;">번호</th>
                <th>제목</th>
                <th style="width: 150px;">작성자</th>
                <th style="width: 180px;">작성일</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($get_data)) : ?>
            <tr>
                <td colspan="4">데이터가 없습니다.</td>
            </tr>
            <?php else : foreach ($get_data as $row) : ?>
            <tr>
                <td><?= $virtual_number-- ?></td>
                <td>
                    <a href="/board/<?= $bo_table ?>/?w=u&mode=form&idx=<?=$row['idx'] ?>"><?= $row['subject'] ?></a>
                </td>
                <td><?= $row['writer'] ?></td>
                <td><?= $row['regdate'] ?></td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <div>
        <?=  $paging ?>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <a href="?mode=form" class="btn btn-primary">글쓰기</a>
        </div>
    </div>
</div>
