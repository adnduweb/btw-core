<button 
    hx-get="<?= $route; ?>?chart_id=<?= $chart_id ?? null; ?>&chart_type=<?= $type ?? null; ?>&period=<?= $period ?? null; ?>"
    hx-swap="none"
    hx-indicator=".progress"
    id="id_<?= uniforme($label, '_') ?? 'button'; ?>_filter_btn" 
    class="bg-white rounded shadow p-2 text-sm flex items-center font-semibold mr-2 cursor-pointer
    <?= isset($selected) && $selected == true ? 'text-indigo-600' : 'text-gray-600' ; ?>"><?= $label ?? 'button'; ?>
  </button>