<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerJ3UsxZc\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerJ3UsxZc/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerJ3UsxZc.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerJ3UsxZc\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerJ3UsxZc\srcDevDebugProjectContainer(array(
    'container.build_hash' => 'J3UsxZc',
    'container.build_id' => '7bb18970',
    'container.build_time' => 1519893086,
));
