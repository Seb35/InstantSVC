import java.io.IOException;

import javax.security.auth.callback.Callback;
import javax.security.auth.callback.CallbackHandler;
import javax.security.auth.callback.UnsupportedCallbackException;

import org.apache.ws.security.WSPasswordCallback;

/**
 * @author Stefan Marr
 *
 */
public class PWCallback implements CallbackHandler {
	
	/**
	 * PWCallback holds username and password as static, cause only one
	 * person cloud be work with a client at a time
	 */
	private static String username;
	private static String password;
	
	public static void setLogin(String username, String password) {
		PWCallback.username = username;
		PWCallback.password = password;
	}
	
	 /**
     * @see javax.security.auth.callback.CallbackHandler#handle(javax.security.auth.callback.Callback[])
     */
    public void handle(Callback[] callbacks) throws IOException, UnsupportedCallbackException {
        for (int i = 0; i < callbacks.length; i++) {

            if (callbacks[i] instanceof WSPasswordCallback) {
                WSPasswordCallback pc = (WSPasswordCallback)callbacks[i];

                if (username == null && (pc.getIdentifer() == null || pc.getIdentifer().length() == 0)) {
                	pc.setPassword(password);
                }
                else if (username.equals(pc.getIdentifer())) {
                	pc.setPassword(password);
                }
            } else {
                throw new UnsupportedCallbackException(callbacks[i], "Unrecognized Callback");
            }
        }
    }

}
