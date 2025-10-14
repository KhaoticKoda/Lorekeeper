<script>
    $(document).ready(function() {
        var $lootTable = $('#lootTableBody');
        var $lootRow = $('#lootRow').find('.loot-row');
        var $itemSelect = $('#lootRowData').find('.item-select');
        var $currencySelect = $('#lootRowData').find('.currency-select');
        @if ($showLootTables)
            var $tableSelect = $('#lootRowData').find('.table-select');
        @endif
        @if ($showRaffles)
            var $raffleSelect = $('#lootRowData').find('.raffle-select');
        @endif

        $('#lootTableBody .selectize').selectize();
        attachRemoveListener($('#lootTableBody .remove-loot-button'));

        $('#addLoot').on('click', function(e) {
            e.preventDefault();
            var $clone = $lootRow.clone();
            $lootTable.append($clone);
            attachRewardTypeListener($clone.find('.reward-type'));
            attachRemoveListener($clone.find('.remove-loot-button'));
        });

        $('.reward-type').on('change', function(e) {
            var val = $(this).val();
            var $cell = $(this).parent().parent().find('.loot-row-select');

            var $clone = null;
            if (val == 'Item') $clone = $itemSelect.clone();
            else if (val == 'Currency') $clone = $currencySelect.clone();
            @if ($showLootTables)
                else if (val == 'LootTable') $clone = $tableSelect.clone();
            @endif
            @if ($showRaffles)
                else if (val == 'Raffle') $clone = $raffleSelect.clone();
            @endif

            $cell.html('');
            $cell.append($clone);
        });

        function attachRewardTypeListener(node) {
            node.on('change', function(e) {
                var val = $(this).val();
                var $cell = $(this).parent().parent().find('.loot-row-select');

                var $clone = null;
                if (val == 'Item') $clone = $itemSelect.clone();
                else if (val == 'Currency') $clone = $currencySelect.clone();
                @if ($showLootTables)
                    else if (val == 'LootTable') $clone = $tableSelect.clone();
                @endif
                @if ($showRaffles)
                    else if (val == 'Raffle') $clone = $raffleSelect.clone();
                @endif

                $cell.html('');
                $cell.append($clone);
                $clone.selectize();
            });
        }

        function attachRemoveListener(node) {
            node.on('click', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        }

        // Weight is a special field
        // check if there is a '.loot-weight' element
        if ($('#lootTableBody .loot-weight').length) {
            console.log('Attaching weight listeners');
            refreshChances();
        }
        function attachWeightListener(node) {
            node.on('change', function(e) {
                refreshChances();
            });
        }

        function refreshChances() {
            var total = 0;
            var weights = [];
            $('#lootTableBody .loot-weight').each(function(index) {
                var current = parseInt($(this).val());
                total += current;
                weights.push(current);
            });


            $('#lootTableBody .loot-row-chance').each(function(index) {
                var current = (weights[index] / total) * 100;
                $(this).html(current.toString() + '%');
            });
        }

    });
</script>
