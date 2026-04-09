<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <main id="container" class="main main_new">


        <section class="mypage-wrap">
            <div class="mypage-inner">

                <?= view('mypage/mypage_sidebar', ['active' => 'staff']) ?>

                <div class="mypage-content">
                    <h3 class="content-title">직원관리</h3>
                    <div class="mypage-content">
                        <div class="staff-search-wrap">

                            <form action="" method="get" id="formSearch" name="formSearch" class="formSearch">
                                <div class="staff-search-box">

                                    <div class="staff-select">
                                        <select name="search_name" id="search_name">
                                            <option <?= $search_name == 'user_id' ? 'selected' : '' ?> value="user_id">
                                                아이디
                                            </option>
                                            <option <?= $search_name == 'user_name' ? 'selected' : '' ?>
                                                    value="user_name">이름
                                            </option>
                                            <option <?= $search_name == 'user_phone' ? 'selected' : '' ?>
                                                    value="user_phone">전화번호
                                            </option>
                                        </select>
                                    </div>

                                    <div class="staff-input">
                                        <input name="search_word" id="search_word" type="text" placeholder="검색어 입력"
                                               value="<?= $search_word ?>">
                                    </div>

                                    <button type="submit" class="staff-btn">검색</button>

                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="table-header">
                        <a href="/staff_create" class="btn-create">
                            <img src="/assets/img/member/create_new.png" alt="">
                            직원등록
                        </a>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                            <tr>
                                <th>번호</th>
                                <th>아이디</th>
                                <th>이메일</th>
                                <th>연락처</th>
                                <th>직급</th>
                                <th>등록일</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($childs)): ?>
                                <tr>
                                    <td style="text-align: center" colspan="6">조회된 데이터가 없습니다</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($childs as $key => $child): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><a href="/staff_create?user_id=<?= $child['user_id'] ?>"><?= $child['user_name'] ?></a></td>
                                    <td><?= $child['user_email'] ?></td>
                                    <td><?= $child['user_phone'] ?></td>
                                    <td><?= $child['work_position'] ?></td>
                                    <td><?= date('Y-m-d', strtotime($child['r_date'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </main>
<?php $this->endSection(); ?>