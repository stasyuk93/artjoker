<?php if($paginate->getCountPages() > 1): ?>
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item <?php if($paginate->getCurrentPage() == 1):?>disabled<?php endif; ?>">
                <a class="page-link" href="<?=$paginate->getUrl(1)?>" tabindex="-1" title="Первая страница">Первая страница</a>
            </li>
            <li class="page-item <?php if($paginate->getCurrentPage() == 1):?>disabled<?php endif; ?>">
                <a class="page-link" href="<?=$paginate->getUrl($paginate->getCurrentPage() - 1)?>" tabindex="-1" title="Предыдущая страница"><</a>
            </li>
            <?php for ($i = $paginate->getStartLink(), $end = $paginate->getEndLink(); $i <= $end; $i++): ?>
                <?php if ($i == $paginate->getCurrentPage()){ ?>
                    <li class="page-item active">
                        <a class="page-link" href="<?=$paginate->getUrl($i)?>"><?=$i?> <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="<?=$paginate->getUrl($i)?>"><?=$i?></a></li>
                <?php } ?>
            <?php endfor;?>
            <li class="page-item <?php if($paginate->getCurrentPage() == $paginate->getCountPages()):?>disabled<?php endif; ?>">
                <a class="page-link" href="<?=$paginate->getUrl($paginate->getCurrentPage() + 1)?>" tabindex="-1" title="Следующая страница">></a>
            </li>
            <li class="page-item <?php if($paginate->getCurrentPage() == $paginate->getCountPages()):?>disabled<?php endif; ?>">
                <a class="page-link" href="<?=$paginate->getUrl($paginate->getCountPages())?>" title="Последняя страница">Последняя страница</a>
            </li>
        </ul>
    </nav>
<?php endif;?>