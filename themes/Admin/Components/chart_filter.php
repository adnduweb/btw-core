<button 
    hx-get="<?= route_to('charts-hx'); ?>?chart_id=<?= $chart_id ?? null; ?>&chart_type=<?= $type ?? null; ?>&period=<?= $period ?? null; ?>"
    hx-swap="none"
    id="id_last_week_filter_btn" 
    class="bg-white rounded shadow p-2 text-sm flex items-center font-semibold mr-2 cursor-pointer
    {% if selected %}text-indigo-600 {% else %}text-gray-600 {% endif %}"><?= $label ?? 'button'; ?>
  </button>