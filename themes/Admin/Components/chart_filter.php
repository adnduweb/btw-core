<button 
    hx-get="<?= route_to('charts-hx-update'); ?>?chart_id=<?= $chart_id ?? null; ?>&chart_type=<?= $type ?? null; ?>&period=<?= $period ?? null; ?>"
    hx-swap="none"
    hx-trigger="click"
    id="id_<?= uniforme($label) ?? 'button'; ?>_filter_btn" 
    class="bg-white rounded shadow p-2 text-sm flex items-center font-semibold mr-2 cursor-pointer
    <?= isset($selected) ? 'text-indigo-600' : 'text-gray-600' ; ?>"><?= $label ?? 'button'; ?>
  </button>