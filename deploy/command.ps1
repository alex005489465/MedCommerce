# 檢查參數
if ($args.Count -lt 2) {
    Write-Error "Please provide two parameters: action (run) and target (network, server, store, or tool)."
    exit 1
}

# 設置參數
$action = $args[0]
$target = $args[1]

# 回到上一層根目錄
Set-Location -Path ".."

# 定義 run 函數
function Start-DockerCompose {
    param (
        [string]$target
    )

    # 設置 Docker Compose 檔案路徑
    $stack = "$target"
    $composeFilePath = "./deploy/docker-compose.$target.yml"

    # 運行 Docker Compose
    docker-compose -p $stack -f $composeFilePath up -d

    if ($?) {
        Write-Output "Docker Compose started successfully with $composeFilePath."
    } else {
        Write-Error "Failed to start Docker Compose with $composeFilePath."
    }
}

# 根據第一個參數執行對應操作
switch ($action) {
    "run" {
        if ($target -eq "all") {
            # 依次運行 store, server, tool
            foreach ($subTarget in @("store", "server", "tool")) {
                Start-DockerCompose -target $subTarget
            }
        } else {
            Start-DockerCompose -target $target
        }
    }
    default {
        Write-Error "Invalid action. Currently supported actions: run."
        exit 1
    }
}

# 回到 deploy 目錄
Set-Location -Path "deploy"
