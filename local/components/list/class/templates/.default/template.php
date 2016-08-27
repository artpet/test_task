<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?>
<div class="main">
  <?foreach ($arResult['ITEMS'] as $item){?>
      <div class="element">
        <div class="element-id">
          Id: <?=$item['ID']?><br>
        </div>
        <div class="element-title">
          Name: <?=$item['NAME']?><br>
        </div>
        <div class="element-text">
          Text: <?=$item['PREVIEW_TEXT']?><br>
        </div>
        <div class="element-sort">
          Sort: <?=$item['SORT']?><br>
        </div>
        <div class="element-date">
          Active date: <?=$item["ACTIVE_FROM"]->toString()?><br>
        </div>
      </div>
  <?}?>
</div>

<?
$APPLICATION->IncludeComponent(
   "bitrix:main.pagenavigation",
   "",
   array(
      "NAV_OBJECT" => $arResult['NAV'],
      "SEF_MODE" => "N",
   ),
   false
);
?>
