

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Current Session Variables</h5>
                <?php if (!empty($_SESSION)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION as $key => $value): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($key); ?></td>
                                    <td>
                                        <?php
                                        if (is_array($value) || is_object($value)) {
                                            echo '<pre>' . htmlspecialchars(print_r($value, true)) . '</pre>';
                                        } else {
                                            echo htmlspecialchars($value);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="alert alert-info">No session variables are currently set.</p>
                <?php endif; ?>
            </div>
        </div>

