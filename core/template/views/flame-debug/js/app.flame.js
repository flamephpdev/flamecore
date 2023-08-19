// # @(FlameView()->import('./main.js'))

const FlameCoreDebugApplicationApp = new FlameCoreDebugApplication()

FlameCoreDebugApplicationApp.createDebuggerPopupBar(JSON.parse(atob(`{{ FlameView()->import('./datas.php') }}`)))
FlameCoreDebugApplicationApp.makeResizableDiv('[debug_console_application="app:@framework_debugger_generated_id()"]')