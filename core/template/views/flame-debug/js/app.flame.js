// # @($_VIEW->import('./main.js'))

const FlameCoreDebugApplicationApp = new FlameCoreDebugApplication()

FlameCoreDebugApplicationApp.createDebuggerPopupBar(JSON.parse(atob(`{{ $_VIEW->import('./datas.php') }}`)))
FlameCoreDebugApplicationApp.makeResizableDiv('[debug_console_application="app:@framework_debugger_generated_id()"]')